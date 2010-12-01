/**
 * ExtJS for the extension manager.
 *
 *
 * @author Steffen Kamper <info@sk-typo3.de>
 * @package TYPO3
 * @subpackage extension manager
 * @version $Id: $
 */

Ext.ns('TYPO3.EM');

TYPO3.EM.Settings = Ext.extend(Ext.FormPanel, {
	border: false,
	labelWidth: 240,
	bodyStyle: 'padding:5px 5px 0',


	initComponent: function() {

		this.repositoryStore = new Ext.data.DirectStore({
			storeId: 'repositoriessettings',
			directFn: TYPO3.EM.ExtDirect.getRepositories,
			idProperty: 'uid',
			root: 'data',
			totalProperty: 'length',
			fields : ['title', 'uid', 'updated', 'count', 'selected', 'description', 'wsdl_url', 'mirror_url'],
			paramsAsHash: true,
			listeners: {
				load: function(store) {
					if (this.isLoaded) {
						record = store.getById(this.repSettingsCombo.getValue()).data;
						this.repositoryInfo(record);
					}
				},
				scope: this
			}
		});

		this.repSettingsCombo = new Ext.form.ComboBox({
			id: 'repSettingsCombo',
			mode: 'local',
			width: 300,
			triggerAction: 'all',
			forceSelection: true,
			editable: false,
			name: 'selectedRepository',
			hiddenName: 'selectedRepository',
			displayField: 'title',
			valueField: 'uid',
			store: this.repositoryStore,
			fieldLabel: 'Select Repository',
			listeners: {
				scope: this,
				select: function(comboBox, newValue, oldValue) {
					this.repositoryInfo(newValue.data);
					TYPO3.EM.ExtDirect.saveSetting('selectedRepository', newValue.data.uid);
				}
			}
		});

		var mirrorData = TYPO3.settings.EM.extMirrors;

		this.mirrorStore = new Ext.data.DirectStore({
			storeId: 'em-mirror-store',
			directFn: TYPO3.EM.ExtDirect.getMirrors,
			idProperty: 'host',
			root: 'data',
			totalProperty: 'length',
			fields: [
				{name : 'title'},
				{name : 'country'},
				{name : 'host'},
				{name : 'path'},
				{name : 'sponsor'},
				{name : 'link'},
				{name : 'logo'}
			]
		});



		var mirrorSm  = new Ext.grid.CheckboxSelectionModel({
			singleSelect: true,
			header: '',
			listeners: {
				'selectionchange': function(selectionModel) {
					var selectedMirror = '';
					if (selectionModel.getSelected()) {
						var sel = selectionModel.getSelected();
						selectedMirror = sel.data.host;
						this.getForm().setValues({selectedMirror: selectedMirror});
					} else {
						this.getForm().setValues({selectedMirror: ''});
					}
					TYPO3.EM.ExtDirect.saveSetting('selectedMirror', selectedMirror);
				},
				scope: this
			}
		});

		var mirrorCm = new Ext.grid.ColumnModel([
			mirrorSm,
			{
				id: 'mirror-title',
				header: TYPO3.lang.mirror,
				width: 200,
				sortable: false,
				menuDisabled: true,
				fixed: true,
				dataIndex: 'title',
				hidable: false
			},{
				id: 'mirror-country',
				header: TYPO3.lang.mirror_country,
				width: 80,
				sortable: false,
				menuDisabled: true,
				fixed: true,
				dataIndex: 'country',
				hidable: false
			},{
				id: 'mirror-host',
				header: TYPO3.lang.mirror_url,
				width: 180,
				sortable: false,
				menuDisabled: true,
				fixed: true,
				dataIndex: 'host',
				hidable: false
			},{
				id: 'mirror-sponsor',
				header: TYPO3.lang.mirror_sponsored_by,
				width: 180,
				sortable: false,
				menuDisabled: true,
				fixed: true,
				dataIndex: 'sponsor',
				hidable: false

			},{
				id: 'mirror-logo',
				header: TYPO3.lang.mirror_logo_link,
				width: 180,
				sortable: false,
				menuDisabled: true,
				fixed: true,
				dataIndex: 'logo',
				hidable: false,
				renderer: function(value, metaData, record, rowIndex, colIndex, store) {
					if (value == '') {
						return ''
					} else {
						return '<a href="' + record.data.link + '" title="' + record.data.sponsor + '" target="_blank"><img src="' + record.data.logo + '" alt="' + record.data.sponsor + '" title="' + record.data.sponsor + '" /></a>';
					}
				}
			}
		]);

		Ext.apply(this, {
			isLoaded: false,
			items: [{
				layout: 'hbox',
				align: 'stretchmax',
				border: false,
				items: [{
					width: 450,
					border: false,
					labelWidth: 100,
					items: [{
							xtype:'fieldset',
							title: TYPO3.lang.user_settings,
							collapsible: true,
							defaults: {},
							defaultType: 'textfield',
							items :[
							{
								fieldLabel: TYPO3.lang.enter_repository_username,
								name: 'fe_u'
							}, {
								fieldLabel: TYPO3.lang.enter_repository_password,
								inputType: 'password',
								name: 'fe_p'
							},
								new Ext.Container({
									html: '<b>' + TYPO3.lang.notice + '</b> ' + TYPO3.lang.repository_password_info,
									xtype: 'displayfield',
									labelWidth: 1
								})
							],
							buttons: [
								{
									text: TYPO3.lang.cmd_save,
									iconCls: 'x-btn-save',
									handler: function() {
										this.saveFormHandler();
									},
									scope: this
								}
							]
						}, {
							xtype:'fieldset',
							title: TYPO3.lang.repositories,
							collapsible: true,
							defaultType: 'textfield',
							items :[
								this.repSettingsCombo,
							{
								title: TYPO3.lang.repository_details,
								xtype: 'panel',
								id: 'repDescriptionDisplay',
								record: null,
								labelWidth: 0,
								width: 420,
								html: '',
								bodyStyle: 'padding: 10px;',
								buttons: [{
									text: TYPO3.lang.cmd_edit,
									iconCls: 'x-btn-edit',
									ref: '../editRep',
									handler: function() {
										var record = this.repositoryStore.getById(this.repSettingsCombo.getValue());
										var win = new TYPO3.EM.EditRepository({
											title: 'Edit Repository "' + record.data.title + '"'
										});
										win.getComponent('repForm').getForm().setValues({
											'title': record.data.title,
											'description': record.data.description,
											'wsdl_url': record.data.wsdl_url,
											'mirror_url': record.data.mirror_url,
											'rep':  record.data.uid
										});
										win.show();
									},
									scope: this
								}, ' ', {
									text: TYPO3.lang.cmd_create,
									iconCls: 'x-btn-new',
									ref: '../newRep',
									handler: function() {
										var win = new TYPO3.EM.EditRepository({
											isCreate: true,
											title: 'Create new Repository'
										}).show();
									},
									scope: this
								}, ' ', {
									text: TYPO3.lang.cmd_delete,
									iconCls: 'x-btn-delete',
									ref: '../deleteRep'
								}]
							}]
						}]
					}, {
						flex: 1,
						border: false,
						items: [{
							xtype:'fieldset',
							title: TYPO3.lang.mirror_selection,
							collapsible: true,
							defaults: {},
							items :[{
								xtype: 'grid',
								id: 'em-mirrorgrid',
								stripeRows: true,
								store: this.mirrorStore,
								cm: mirrorCm,
								sm: mirrorSm,
								viewConfig: {
									forceFit: true
								},
								height: 450
							},{
								xtype: 'hidden',
								name: 'selectedMirror'
							}]
						}]
					}]
				}]
		});


		// call parent
		TYPO3.EM.Settings.superclass.initComponent.apply(this, arguments);

	} ,

	saveFormHandler: function() {
		this.getForm().submit({
			waitMsg : 'Saving Settings...',
			success: function(form, action) {
				TYPO3.Flashmessage.display(TYPO3.Severity.information,'Settings', 'Settings were saved ', 5);
				TYPO3.settings.EM.hasCredentials = (action.result.data.fe_u !== '' && action.result.data.fe_p !== '')
			},
			failure: function(form, action) {
				if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
					TYPO3.Flashmessage.display(TYPO3.Severity.error, 'Error',
							'Status:'+action.response.status+': '+
							action.response.statusText, 5);
				}
				if (action.failureType === Ext.form.Action.SERVER_INVALID){
					// server responded with success = false
					TYPO3.Flashmessage.display(TYPO3.Severity.error, 'Invalid', action.result.errormsg, 5);
				}
			}

		});
	},

	repositoryInfo: function(record) {
		var panel = Ext.getCmp('repDescriptionDisplay');
		panel.update([
			'<h1 class="h1Panel">',record.title, '</h1>',
			'<p class="panelDescription">', record.description, '</p>',
			'<p><b>', 'Mirror URL: ', '</b>', record.mirror_url, '<br />',
			'<b>', 'WSDL URL: ', '</b>', record.wsdl_url, '</p>'
		].join(''));
		if (record.uid == 1) {
			panel.editRep.disable();
			panel.deleteRep.disable();
		} else {
			panel.editRep.enable();
			panel.deleteRep.enable();
		}
		this.mirrorStore.load({
			params: {
				repository: this.repSettingsCombo.getValue()
			},
			callback: function() {
				var mirror = this.getForm().getValues().selectedMirror;
				if (mirror) {
					var record = this.mirrorStore.getAt(this.mirrorStore.find('host', mirror));
					Ext.getCmp('em-mirrorgrid').getSelectionModel().selectRecords([record]);
				} else {
					Ext.getCmp('em-mirrorgrid').getSelectionModel().selectFirstRow();
				}
			},
			scope: this
		});

	},


	onRender:function() {

		// call parent
		TYPO3.EM.Settings.superclass.onRender.apply(this, arguments);

		Ext.apply(this.getForm(),{
			api: {
				load: TYPO3.EM.ExtDirect.settingsFormLoad,
				submit: TYPO3.EM.ExtDirect.settingsFormSubmit
			},
			paramsAsHash: false
		});

		this.repositoryStore.load();
		this.getForm().load({
			success: function(form, response) {
				record = this.repositoryStore.getById(this.repSettingsCombo.getValue()).data;
				this.repositoryInfo(record);
				this.isLoaded = true;
			},
			scope: this
		});

	}




});

// register xtype
Ext.reg('extsettings', TYPO3.EM.Settings);

// window with repository edit/create form
TYPO3.EM.EditRepository = Ext.extend(Ext.Window, {
	isCreate: false,
	width: 500,
	height: 260,
	layout: 'fit',
	frame: true,
	resizable: false,
	modal: true,
	caller: null,
	initComponent : function() {
		var form = new Ext.form.FormPanel({
			//baseCls: 'x-plain',
			border: false,
			labelWidth: 80,
			itemId: 'repForm',
			bodyStyle:'padding:5px 5px 0',
			width: 350,
			defaults: {width: 380},
			defaultType: 'textfield',
			api: {
				submit: TYPO3.EM.ExtDirect.repositoryEditFormSubmit
			},
			paramsAsHash: false,
			items: [{
				itemId: 'title',
				fieldLabel: 'Title',
				name: 'title'
			}, {
				itemId: 'description',
				fieldLabel: 'Description',
				xtype: 'textarea',
				name: 'description',
				height: 100
			}, {
				itemId: 'mirror_url',
				fieldLabel: 'Mirror URL',
				name: 'mirror_url'
			}, {
				itemId: 'wsdl_url',
				fieldLabel: 'WSDL URL',
				name: 'wsdl_url'
			}, {
				xtype: 'hidden',
				name: 'create',
				value: this.isCreate ? 1 : 0
			}, {
				xtype: 'hidden',
				name: 'rep',
				value: 0
			}]
		});

		Ext.apply(this, {
			items: form,
			buttons : [{
				text: 'Create',
				iconCls: 'x-btn-save',
				handler: function() {
					this.repositoryUpdate(form, 1);
				},
				hidden: !this.isCreate,
				scope: this
			}, {
				text: 'Update',
				iconCls: 'x-btn-save',
				handler: function() {
				  this.repositoryUpdate(form, 0);
				},
				hidden: this.isCreate,
				scope: this
			}, {
				text: 'Cancel',
				iconCls: 'x-btn-cancel',
				handler: function() {
					this.close();
				},
				scope: this
			}]
		});
		TYPO3.EM.EditRepository.superclass.initComponent.call(this);
	},

	repositoryUpdate: function(form, type) {

		form.getForm().submit({
			waitMsg : type === 0 ? 'Saving Repository...' : 'Creating Repository ...',
			success: function(form, action) {
				TYPO3.Flashmessage.display(TYPO3.Severity.information,'Repository', 'Repository was ' + (type == 0 ? 'saved.' : 'created.'), 5);
				Ext.StoreMgr.get('repositoriessettings').load();
				this.close();
			},
			failure: function(form, action) {
				if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
					TYPO3.Flashmessage.display(TYPO3.Severity.error, 'Error',
							'Status:'+action.response.status+': '+
							action.response.statusText, 5);
				}
				if (action.failureType === Ext.form.Action.SERVER_INVALID){
					// server responded with success = false
					TYPO3.Flashmessage.display(TYPO3.Severity.error, 'Invalid', action.result.errormsg, 15);
				}
			},
			scope: this
		});
	}

});
