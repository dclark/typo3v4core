/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Steffen Kamper <info@sk-typo3.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * ExtJS for the extension manager.
 *
 *
 * @author Steffen Kamper <info@sk-typo3.de>
 * @package TYPO3
 * @subpackage extension manager
 * @version $Id: $
 */
Ext.ns('TYPO3.EM', 'TYPO3.EM.GridColumns');

TYPO3.EM.LocalList = Ext.extend(Ext.grid.GridPanel, {
	border:false,
	stripeRows: true,
	stateful: true,
	stateId: 'LocalList',
	stateEvents: ['columnmove', 'columnresize', 'sortchange', 'groupchange'],

	rowExpander: new Ext.ux.grid.RowPanelExpander({
		hideable: false,
		createExpandingRowPanelItems: function(record, rowIndex){
			var panelItems = [
				new Ext.TabPanel({
					plain: true,
					activeTab: 0,
					defaults: {
						bodyStyle: 'background:#fff;padding:10px;',
						boxMinHeight: 150
					},
					record: record,
					items:[
						{
							title: TYPO3.lang.msg_info,
							autoHeight: true,
							listeners: {
								activate: function(panel) {
									TYPO3.EM.Layouts.showExtInfo(panel, panel.ownerCt.record.data);
								}
							}
						},
						{
							title: TYPO3.lang.msg_update,
							html: '<div class="loading-indicator">Loading...</div>',
							disabled: record.data.installed === 0,
							listeners: {
								activate: function(panel) {
									TYPO3.EM.ExtDirect.getExtensionUpdate(record.data.extkey, function(response) {
										panel.update(response);
									});
								}
							}
						},
						{
							title: TYPO3.lang.msg_configuration,
							xtype: 'form',
							disabled: record.data.installed === 0,
							autoHeight: true,
							html: '<div class="loading-indicator">Loading...</div>',
							listeners: {
								activate: function(panel) {
									TYPO3.EM.ExtDirect.getExtensionConfiguration(record.data.extkey, function(response) {
										panel.update(response, true, this.readConfigForm.createDelegate(this));
									}, this);
								}
							},
							scope: this,
							readConfigForm: function() {
								var key = record.data.extkey;
								var button = Ext.select('input[type="submit"]');
								if (button) {
									button.on('click', function() {
										Ext.apply(this.form,{
										api: {
											submit: TYPO3.EM.ExtDirect.saveExtensionConfiguration
										},
										paramsAsHash: false

									});
										this.form.submit({
											waitMsg : 'Saving Settings...',
											success: function(form, action) {
												TYPO3.Flashmessage.display(TYPO3.Severity.information, TYPO3.lang.msg_configuration, TYPO3.lang.configurationSaved, 5);
											},
											failure: function(form, action) {
												if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
													TYPO3.Flashmessage.display(TYPO3.Severity.error, TYPO3.lang.msg_error,
																			TYPO3.lang.msg_error + ':' + action.response.status + ': ' +
																			action.response.statusText, 5);
											}
											if (action.failureType === Ext.form.Action.SERVER_INVALID) {
													// server responded with success = false
												TYPO3.Flashmessage.display(TYPO3.Severity.error, TYPO3.lang.invalid, action.result.errormsg, 5);
											}
										 }
									 });
									}, this);
								}
							}
						},
						{
							title: TYPO3.lang.msg_files,
							xtype: 'extfilelist',
							recordData: record.data

						},
						{
							xtype: 'terupload',
							title: TYPO3.lang.msg_terupload,
							recordData: record.data,
							disabled: !TYPO3.settings.EM.hasCredentials
						},
						{
							title: TYPO3.lang.msg_developerinformation,
							autoHeight: true,
							html: '<div class="loading-indicator">' + TYPO3.lang.action_loading+ '</div>',
							listeners: {
								activate: function(panel) {
									TYPO3.EM.ExtDirect.getExtensionDevelopInfo(record.data.extkey, function(response) {
										panel.update(response);
									});
								}
							}
						},
						{
							title: TYPO3.lang.details_backup_delete,
							disabled: true //record.data.installed === 0
						}
					]
				})
			];
			return panelItems;
		}
	}),

	initComponent:function() {
		var localstore = new Ext.data.GroupingStore({
			storeId: 'localstore',
			proxy: new Ext.data.DirectProxy({
				directFn: TYPO3.EM.ExtDirect.getExtensionList
			}),

			reader: new Ext.data.JsonReader({
				idProperty: 'extkey',
				root: 'data',
				totalProperty: 'length',
				fields:[
					{name:'install'},
					{name:'title'},
					{name:'extkey'},
					{name:'category'},
					{name:'version'},
					{name:'type'},
					{name:'state'},
					{name:'icon'},
					{name:'description'},
					{name:'shy'},
					{name:'installed'},
					{name:'author'},
					{name:'author_email'},
					{name:'author_company'},
					{name:'download'},
					{name:'doc'},
					{name:'typeShort'},
					{name:'nodePath'}
				]
			}),

			sortInfo:{
				field: 'title',
				direction: 'ASC'
			},
			remoteSort: false,
			groupField: 'category',
			showAction: false,
			listeners: {
				beforeload: function() {
					this.reloadButton.disable();
				},
				datachanged: function(store){
					Ext.getCmp('displayExtensionLabel').setText(TYPO3.lang.extensions + ' ' + store.data.length);
					var hasFilters = false;
					TYPO3.EM.Filters.filters.each(function (filter) {
						if (filter.active) {
							hasFilters = true;
						}
					});
					if (hasFilters) {
						this.doClearFilters.show();
					} else {
						this.doClearFilters.hide();
					}
				},
				load: function(store) {
					this.reloadButton.enable();
					if (store.showAction) {
						this.showExtension.defer(500, this);
					}
				},

				scope: this
			},
			validateRecord: function(record){
				//return false; //testcase
				var control = Ext.getCmp('localSearchField');
				if (control) {
					var filtertext = control.getRawValue();
					if (filtertext) {
							//filter by search string
						var re = new RegExp(Ext.escapeRe(filtertext));
						var isMatched = record.data.extkey.match(re) || record.data.title.match(re);
						if (!isMatched) {
							return false;
						}
					}
				}
				if (TYPO3.settings.EM.display_obsolete === '0' && record.data.state === 'obsolete'){
					return false;
				}
				if (TYPO3.settings.EM.display_shy === '0' && record.data.shy == 1){
					return false;
				}
				if (TYPO3.settings.EM.display_installed === '1' && record.data.installed == 0) {
					return false;
				}

				return true;
			}
		});

		var searchField = new Ext.ux.form.FilterField({
			store: localstore,
			id: 'localSearchField',
			width: 200
		});

		var cm = new Ext.grid.ColumnModel({
			columns: [
				this.rowExpander,
				TYPO3.EM.GridColumns.InstallExtension,
				TYPO3.EM.GridColumns.ExtensionTitle,
				TYPO3.EM.GridColumns.ExtensionKey,
				TYPO3.EM.GridColumns.ExtensionCategory,
				TYPO3.EM.GridColumns.ExtensionAuthor,
				TYPO3.EM.GridColumns.ExtensionType,
				TYPO3.EM.GridColumns.ExtensionState
			],
			defaults: {
				sortable: true
			}

		});



		Ext.apply(this, {
			itemId: 'em-localLocalExtensionlist',
			title: TYPO3.lang.localExtensionList,
			loadMask: {msg: TYPO3.lang.action_loading_extlist},
			layout: 'fit',
			store: localstore,
			cm: cm,
			plugins: [this.rowExpander, TYPO3.EM.Filters],
			view : new Ext.grid.GroupingView({
				forceFit : true,
				groupTextTpl : '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "' + TYPO3.lang.msg_items + '" : "' + TYPO3.lang.msg_item + '"]})',
				enableRowBody: true,
				showPreview: true,
				getRowClass: this.applyRowClass,
				iconCls: 'icon-grid',
				hideGroupedColumn: true
			}),

			tbar: [
				{
					xtype: 'tbtext',
					text: TYPO3.lang.cmd_filter
				},
				searchField,
				{
					iconCls: 'x-tbar-loading',
					ref: '../reloadButton',
					handler: function() {
						this.store.reload();
					},
					scope: this
				}, '-', {
					text: TYPO3.lang.cmd_ClearAllFilters,
					ref: '../doClearFilters',
					handler: function() {
						TYPO3.EM.Filters.clearFilters();
					},
					scope: this,
					hidden: true
				},
				'->',
				{
					id: 'installedFlag',
					xtype: 'checkbox',
					checked: TYPO3.settings.EM.display_installed === '1' ? true : false,
					boxLabel: TYPO3.lang.display_installedOnly + '&nbsp;',
					listeners: {
						check: function(checkbox, checked) {
							TYPO3.settings.EM.display_installed =  checked ? '1' : '0';
							TYPO3.EM.ExtDirect.saveSetting('display_installed', TYPO3.settings.EM.display_installed);
							localstore.filterBy(localstore.validateRecord, this);
						},
						scope: this
					}
				}, {
					id: 'shyFlag',
					xtype: 'checkbox',
					checked: TYPO3.settings.EM.display_shy === '1' ? true : false,
					boxLabel: TYPO3.lang.display_shy + '&nbsp;',
					listeners: {
						check: function(checkbox, checked) {
							TYPO3.settings.EM.display_shy =  checked ? '1' : '0';
							TYPO3.EM.ExtDirect.saveSetting('display_shy', TYPO3.settings.EM.display_shy);
							localstore.filterBy(localstore.validateRecord, this);
						},
						scope: this
					}
				},{
					id: 'obsoleteFlag',
					xtype: 'checkbox',
					checked: TYPO3.settings.EM.display_obsolete === '1' ? true : false,
					boxLabel: TYPO3.lang.display_obsolete + '&nbsp;',
					listeners: {
						check: function(checkbox, checked) {
							TYPO3.settings.EM.display_obsolete =  checked ? '1' : '0';
							TYPO3.EM.ExtDirect.saveSetting('display_obsolete', TYPO3.settings.EM.display_obsolete);
							localstore.filterBy(localstore.validateRecord, this);
						} ,
						scope: this
					}
				}
			],
			bbar:[
				{
					xtype: 'tbtext',
					text: TYPO3.lang.action_loading_extlist,
					id: 'displayExtensionLabel',
					style: {fontWeight: 'bold'}
				},
				'->',
				{
					text: TYPO3.lang.repositoryUploadForm_upload,
					handler : function(){
						TYPO3.EM.Tools.uploadExtension();
					}
				}, ' ', {
					text: TYPO3.lang.cmd_ClearGrouping,
					handler : function(){
						localstore.clearGrouping();
					}
				}
			]
		});

		TYPO3.EM.LocalList.superclass.initComponent.apply(this, arguments);

		/* get install / uninstall clicks */
		this.on('cellclick', function(grid, rowIndex, columnIndex, event) {
			var record = grid.getStore().getAt(rowIndex);  // Get the Record

			if (columnIndex === 1) { // column with install / remove images
				if (event.getTarget('.installExtension', 1)) {
					// install extension
				}
				if (event.getTarget('.removeExtension', 1)) {
					// remove extension
				}
			}
		}, this);

		/*this.on('staterestore', function() {
			this.store.filterBy(this.store.storeFilter, this);
		}, this);   */
		localstore.load();
	},


	showExtension: function() {
		var row = this.store.find('extkey', this.store.showAction);
		if (row) {
			this.rowExpander.expandRow(row);
			this.getSelectionModel().selectRow(row);
			this.getView().focusRow(row);
		}
		this.store.showAction = false;
	},

	onRender: function() {
		TYPO3.EM.LocalList.superclass.onRender.apply(this, arguments);
	},

	afterRender: function() {
		TYPO3.EM.LocalList.superclass.afterRender.apply(this, arguments);
	}



});

Ext.reg('TYPO3.EM.LocalList', TYPO3.EM.LocalList);
