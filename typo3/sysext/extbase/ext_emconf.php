<?php

########################################################################
# Extension Manager/Repository config file for ext "extbase".
#
# Auto generated 24-08-2010 12:04
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'A Framework for Extensions',
	'description' => 'A framework to build extensions in the style of FLOW3 by now.',
	'category' => 'misc',
	'author' => 'TYPO3 core team',
	'author_email' => '',
	'shy' => '',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => 'top',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author_company' => '',
	'version' => '1.3.0',
	'constraints' => array(
		'depends' => array(
			'php' => '5.2.0-0.0.0',
			'typo3' => '4.4.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
	'_md5_values_when_last_written' => 'a:269:{s:13:"ChangeLog.txt";s:4:"7c71";s:17:"RELEASE_NOTES.txt";s:4:"a3ac";s:16:"ext_autoload.php";s:4:"216e";s:12:"ext_icon.gif";s:4:"e922";s:17:"ext_localconf.php";s:4:"5fa5";s:14:"ext_tables.php";s:4:"33b4";s:14:"ext_tables.sql";s:4:"6ad6";s:24:"ext_typoscript_setup.txt";s:4:"a6a3";s:19:"last_synched_target";s:4:"3132";s:22:"Classes/Dispatcher.php";s:4:"f0d4";s:21:"Classes/Exception.php";s:4:"c346";s:54:"Classes/Configuration/AbstractConfigurationManager.php";s:4:"69f5";s:53:"Classes/Configuration/BackendConfigurationManager.php";s:4:"62be";s:35:"Classes/Configuration/Exception.php";s:4:"31e6";s:54:"Classes/Configuration/FrontendConfigurationManager.php";s:4:"bc35";s:53:"Classes/Configuration/Exception/ContainerIsLocked.php";s:4:"a34d";s:60:"Classes/Configuration/Exception/InvalidConfigurationType.php";s:4:"e100";s:46:"Classes/Configuration/Exception/NoSuchFile.php";s:4:"ba93";s:48:"Classes/Configuration/Exception/NoSuchOption.php";s:4:"1369";s:46:"Classes/Configuration/Exception/ParseError.php";s:4:"da56";s:37:"Classes/Domain/Model/FrontendUser.php";s:4:"b55f";s:42:"Classes/Domain/Model/FrontendUserGroup.php";s:4:"8a6f";s:57:"Classes/Domain/Repository/FrontendUserGroupRepository.php";s:4:"0b75";s:52:"Classes/Domain/Repository/FrontendUserRepository.php";s:4:"82e9";s:45:"Classes/DomainObject/AbstractDomainObject.php";s:4:"8f53";s:39:"Classes/DomainObject/AbstractEntity.php";s:4:"94ce";s:44:"Classes/DomainObject/AbstractValueObject.php";s:4:"cf30";s:46:"Classes/DomainObject/DomainObjectInterface.php";s:4:"2d94";s:23:"Classes/Error/Error.php";s:4:"d136";s:25:"Classes/MVC/Exception.php";s:4:"606f";s:23:"Classes/MVC/Request.php";s:4:"52fc";s:32:"Classes/MVC/RequestInterface.php";s:4:"0617";s:24:"Classes/MVC/Response.php";s:4:"1f30";s:33:"Classes/MVC/ResponseInterface.php";s:4:"3c5e";s:45:"Classes/MVC/Controller/AbstractController.php";s:4:"be04";s:43:"Classes/MVC/Controller/ActionController.php";s:4:"77c1";s:35:"Classes/MVC/Controller/Argument.php";s:4:"6865";s:40:"Classes/MVC/Controller/ArgumentError.php";s:4:"501b";s:36:"Classes/MVC/Controller/Arguments.php";s:4:"2281";s:45:"Classes/MVC/Controller/ArgumentsValidator.php";s:4:"e859";s:44:"Classes/MVC/Controller/ControllerContext.php";s:4:"70e4";s:46:"Classes/MVC/Controller/ControllerInterface.php";s:4:"99d2";s:40:"Classes/MVC/Controller/FlashMessages.php";s:4:"ef89";s:38:"Classes/MVC/Exception/InfiniteLoop.php";s:4:"7f60";s:43:"Classes/MVC/Exception/InvalidActionName.php";s:4:"46a7";s:45:"Classes/MVC/Exception/InvalidArgumentName.php";s:4:"0b57";s:45:"Classes/MVC/Exception/InvalidArgumentType.php";s:4:"75f1";s:46:"Classes/MVC/Exception/InvalidArgumentValue.php";s:4:"655c";s:43:"Classes/MVC/Exception/InvalidController.php";s:4:"300c";s:47:"Classes/MVC/Exception/InvalidControllerName.php";s:4:"fdd5";s:46:"Classes/MVC/Exception/InvalidExtensionName.php";s:4:"adaf";s:39:"Classes/MVC/Exception/InvalidMarker.php";s:4:"31c5";s:48:"Classes/MVC/Exception/InvalidOrNoRequestHash.php";s:4:"0238";s:46:"Classes/MVC/Exception/InvalidRequestMethod.php";s:4:"901e";s:44:"Classes/MVC/Exception/InvalidRequestType.php";s:4:"cfd5";s:49:"Classes/MVC/Exception/InvalidTemplateResource.php";s:4:"23b5";s:43:"Classes/MVC/Exception/InvalidUriPattern.php";s:4:"55b9";s:43:"Classes/MVC/Exception/InvalidViewHelper.php";s:4:"c516";s:38:"Classes/MVC/Exception/NoSuchAction.php";s:4:"55bf";s:40:"Classes/MVC/Exception/NoSuchArgument.php";s:4:"4612";s:42:"Classes/MVC/Exception/NoSuchController.php";s:4:"6798";s:36:"Classes/MVC/Exception/StopAction.php";s:4:"b9f4";s:48:"Classes/MVC/Exception/UnsupportedRequestType.php";s:4:"c538";s:33:"Classes/MVC/View/AbstractView.php";s:4:"7351";s:30:"Classes/MVC/View/EmptyView.php";s:4:"775f";s:34:"Classes/MVC/View/ViewInterface.php";s:4:"4858";s:27:"Classes/MVC/Web/Request.php";s:4:"0f1f";s:34:"Classes/MVC/Web/RequestBuilder.php";s:4:"fb31";s:28:"Classes/MVC/Web/Response.php";s:4:"7156";s:38:"Classes/MVC/Web/Routing/UriBuilder.php";s:4:"9d62";s:28:"Classes/Object/Exception.php";s:4:"dfa3";s:26:"Classes/Object/Manager.php";s:4:"c356";s:35:"Classes/Object/ManagerInterface.php";s:4:"b5a1";s:36:"Classes/Object/RegistryInterface.php";s:4:"2389";s:36:"Classes/Object/TransientRegistry.php";s:4:"6170";s:46:"Classes/Object/Exception/CannotBuildObject.php";s:4:"1147";s:53:"Classes/Object/Exception/CannotReconstituteObject.php";s:4:"0f10";s:41:"Classes/Object/Exception/InvalidClass.php";s:4:"7815";s:42:"Classes/Object/Exception/InvalidObject.php";s:4:"f118";s:55:"Classes/Object/Exception/InvalidObjectConfiguration.php";s:4:"97ef";s:52:"Classes/Object/Exception/ObjectAlreadyRegistered.php";s:4:"a4fc";s:41:"Classes/Object/Exception/UnknownClass.php";s:4:"555d";s:45:"Classes/Object/Exception/UnknownInterface.php";s:4:"9ff5";s:42:"Classes/Object/Exception/UnknownObject.php";s:4:"11f0";s:51:"Classes/Object/Exception/UnresolvedDependencies.php";s:4:"2163";s:39:"Classes/Object/Exception/WrongScope.php";s:4:"f151";s:31:"Classes/Persistence/Backend.php";s:4:"9c67";s:40:"Classes/Persistence/BackendInterface.php";s:4:"36cf";s:33:"Classes/Persistence/Exception.php";s:4:"1713";s:35:"Classes/Persistence/IdentityMap.php";s:4:"9d38";s:40:"Classes/Persistence/LazyLoadingProxy.php";s:4:"c731";s:41:"Classes/Persistence/LazyObjectStorage.php";s:4:"6ce0";s:48:"Classes/Persistence/LoadingStrategyInterface.php";s:4:"d4ed";s:31:"Classes/Persistence/Manager.php";s:4:"a834";s:40:"Classes/Persistence/ManagerInterface.php";s:4:"d304";s:49:"Classes/Persistence/ObjectMonitoringInterface.php";s:4:"8d6e";s:37:"Classes/Persistence/ObjectStorage.php";s:4:"7201";s:36:"Classes/Persistence/PropertyType.php";s:4:"3dbb";s:29:"Classes/Persistence/Query.php";s:4:"f547";s:36:"Classes/Persistence/QueryFactory.php";s:4:"35b4";s:45:"Classes/Persistence/QueryFactoryInterface.php";s:4:"a61d";s:38:"Classes/Persistence/QueryInterface.php";s:4:"27f5";s:46:"Classes/Persistence/QuerySettingsInterface.php";s:4:"3b55";s:34:"Classes/Persistence/Repository.php";s:4:"1ede";s:43:"Classes/Persistence/RepositoryInterface.php";s:4:"164f";s:31:"Classes/Persistence/Session.php";s:4:"43b4";s:42:"Classes/Persistence/Typo3QuerySettings.php";s:4:"62ab";s:56:"Classes/Persistence/Exception/CleanStateNotMemorized.php";s:4:"5fe6";s:51:"Classes/Persistence/Exception/IllegalObjectType.php";s:4:"73e7";s:46:"Classes/Persistence/Exception/InvalidClass.php";s:4:"5dae";s:60:"Classes/Persistence/Exception/InvalidNumberOfConstraints.php";s:4:"3fe3";s:53:"Classes/Persistence/Exception/InvalidPropertyType.php";s:4:"5590";s:48:"Classes/Persistence/Exception/MissingBackend.php";s:4:"0db5";s:53:"Classes/Persistence/Exception/RepositoryException.php";s:4:"d09e";s:42:"Classes/Persistence/Exception/TooDirty.php";s:4:"e984";s:57:"Classes/Persistence/Exception/UnexpectedTypeException.php";s:4:"20b3";s:47:"Classes/Persistence/Exception/UnknownObject.php";s:4:"82d9";s:51:"Classes/Persistence/Exception/UnsupportedMethod.php";s:4:"0180";s:50:"Classes/Persistence/Exception/UnsupportedOrder.php";s:4:"3c5e";s:53:"Classes/Persistence/Exception/UnsupportedRelation.php";s:4:"ca3b";s:40:"Classes/Persistence/Mapper/ColumnMap.php";s:4:"1abc";s:38:"Classes/Persistence/Mapper/DataMap.php";s:4:"2d9a";s:45:"Classes/Persistence/Mapper/DataMapFactory.php";s:4:"d88d";s:41:"Classes/Persistence/Mapper/DataMapper.php";s:4:"293f";s:40:"Classes/Persistence/QOM/AndInterface.php";s:4:"ae8d";s:45:"Classes/Persistence/QOM/BindVariableValue.php";s:4:"f52e";s:54:"Classes/Persistence/QOM/BindVariableValueInterface.php";s:4:"eb03";s:38:"Classes/Persistence/QOM/Comparison.php";s:4:"9740";s:47:"Classes/Persistence/QOM/ComparisonInterface.php";s:4:"10ac";s:38:"Classes/Persistence/QOM/Constraint.php";s:4:"1f0e";s:47:"Classes/Persistence/QOM/ConstraintInterface.php";s:4:"3b4b";s:42:"Classes/Persistence/QOM/DynamicOperand.php";s:4:"5266";s:51:"Classes/Persistence/QOM/DynamicOperandInterface.php";s:4:"91b0";s:45:"Classes/Persistence/QOM/EquiJoinCondition.php";s:4:"35c2";s:54:"Classes/Persistence/QOM/EquiJoinConditionInterface.php";s:4:"b873";s:32:"Classes/Persistence/QOM/Join.php";s:4:"4c13";s:50:"Classes/Persistence/QOM/JoinConditionInterface.php";s:4:"4b8d";s:41:"Classes/Persistence/QOM/JoinInterface.php";s:4:"144a";s:38:"Classes/Persistence/QOM/LogicalAnd.php";s:4:"a250";s:38:"Classes/Persistence/QOM/LogicalNot.php";s:4:"75e9";s:37:"Classes/Persistence/QOM/LogicalOr.php";s:4:"6da2";s:37:"Classes/Persistence/QOM/LowerCase.php";s:4:"93e4";s:46:"Classes/Persistence/QOM/LowerCaseInterface.php";s:4:"e093";s:40:"Classes/Persistence/QOM/NotInterface.php";s:4:"0ec5";s:35:"Classes/Persistence/QOM/Operand.php";s:4:"ba74";s:44:"Classes/Persistence/QOM/OperandInterface.php";s:4:"1928";s:39:"Classes/Persistence/QOM/OrInterface.php";s:4:"9cf8";s:36:"Classes/Persistence/QOM/Ordering.php";s:4:"8427";s:45:"Classes/Persistence/QOM/OrderingInterface.php";s:4:"c949";s:41:"Classes/Persistence/QOM/PropertyValue.php";s:4:"5905";s:50:"Classes/Persistence/QOM/PropertyValueInterface.php";s:4:"80ef";s:62:"Classes/Persistence/QOM/QueryObjectModelConstantsInterface.php";s:4:"0773";s:51:"Classes/Persistence/QOM/QueryObjectModelFactory.php";s:4:"6923";s:60:"Classes/Persistence/QOM/QueryObjectModelFactoryInterface.php";s:4:"3b53";s:36:"Classes/Persistence/QOM/Selector.php";s:4:"f3aa";s:45:"Classes/Persistence/QOM/SelectorInterface.php";s:4:"5afa";s:43:"Classes/Persistence/QOM/SourceInterface.php";s:4:"0885";s:37:"Classes/Persistence/QOM/Statement.php";s:4:"90ae";s:41:"Classes/Persistence/QOM/StaticOperand.php";s:4:"a244";s:50:"Classes/Persistence/QOM/StaticOperandInterface.php";s:4:"a163";s:37:"Classes/Persistence/QOM/UpperCase.php";s:4:"9d77";s:46:"Classes/Persistence/QOM/UpperCaseInterface.php";s:4:"bfc0";s:48:"Classes/Persistence/Storage/BackendInterface.php";s:4:"3604";s:46:"Classes/Persistence/Storage/Typo3DbBackend.php";s:4:"4eac";s:55:"Classes/Persistence/Storage/Exception/BadConstraint.php";s:4:"3a87";s:50:"Classes/Persistence/Storage/Exception/SqlError.php";s:4:"850b";s:30:"Classes/Property/Exception.php";s:4:"e64b";s:27:"Classes/Property/Mapper.php";s:4:"d5b9";s:35:"Classes/Property/MappingResults.php";s:4:"abac";s:49:"Classes/Property/Exception/FormatNotSupported.php";s:4:"8044";s:46:"Classes/Property/Exception/InvalidDataType.php";s:4:"5064";s:44:"Classes/Property/Exception/InvalidFormat.php";s:4:"0b83";s:46:"Classes/Property/Exception/InvalidProperty.php";s:4:"1cb3";s:44:"Classes/Property/Exception/InvalidSource.php";s:4:"61e6";s:44:"Classes/Property/Exception/InvalidTarget.php";s:4:"ea9e";s:38:"Classes/Reflection/ClassReflection.php";s:4:"203d";s:34:"Classes/Reflection/ClassSchema.php";s:4:"113a";s:39:"Classes/Reflection/DocCommentParser.php";s:4:"fd1a";s:32:"Classes/Reflection/Exception.php";s:4:"ec59";s:39:"Classes/Reflection/MethodReflection.php";s:4:"32fd";s:35:"Classes/Reflection/ObjectAccess.php";s:4:"3f78";s:42:"Classes/Reflection/ParameterReflection.php";s:4:"351b";s:41:"Classes/Reflection/PropertyReflection.php";s:4:"d5fd";s:30:"Classes/Reflection/Service.php";s:4:"c400";s:52:"Classes/Reflection/Exception/InvalidPropertyType.php";s:4:"82e0";s:30:"Classes/Security/Exception.php";s:4:"3b45";s:47:"Classes/Security/Channel/RequestHashService.php";s:4:"2f64";s:45:"Classes/Security/Cryptography/HashService.php";s:4:"91ca";s:63:"Classes/Security/Exception/InvalidArgumentForHashGeneration.php";s:4:"8d5c";s:70:"Classes/Security/Exception/InvalidArgumentForRequestHashGeneration.php";s:4:"81bd";s:60:"Classes/Security/Exception/SyntacticallyWrongRequestHash.php";s:4:"23d0";s:26:"Classes/Utility/Arrays.php";s:4:"c4ee";s:25:"Classes/Utility/Cache.php";s:4:"2501";s:31:"Classes/Utility/ClassLoader.php";s:4:"d7ce";s:44:"Classes/Utility/ExtbaseRequirementsCheck.php";s:4:"83d5";s:29:"Classes/Utility/Extension.php";s:4:"d297";s:32:"Classes/Utility/Localization.php";s:4:"a818";s:32:"Classes/Utility/TypeHandling.php";s:4:"7c63";s:30:"Classes/Utility/TypoScript.php";s:4:"499a";s:28:"Classes/Validation/Error.php";s:4:"247a";s:32:"Classes/Validation/Exception.php";s:4:"44f8";s:36:"Classes/Validation/PropertyError.php";s:4:"3267";s:40:"Classes/Validation/ValidatorResolver.php";s:4:"27f8";s:47:"Classes/Validation/Exception/InvalidSubject.php";s:4:"5040";s:63:"Classes/Validation/Exception/InvalidValidationConfiguration.php";s:4:"9cfa";s:57:"Classes/Validation/Exception/InvalidValidationOptions.php";s:4:"a3a8";s:48:"Classes/Validation/Exception/NoSuchValidator.php";s:4:"64f4";s:49:"Classes/Validation/Exception/NoValidatorFound.php";s:4:"be96";s:59:"Classes/Validation/Validator/AbstractCompositeValidator.php";s:4:"7eaf";s:56:"Classes/Validation/Validator/AbstractObjectValidator.php";s:4:"f3e3";s:50:"Classes/Validation/Validator/AbstractValidator.php";s:4:"8477";s:54:"Classes/Validation/Validator/AlphanumericValidator.php";s:4:"5740";s:53:"Classes/Validation/Validator/ConjunctionValidator.php";s:4:"d60b";s:50:"Classes/Validation/Validator/DateTimeValidator.php";s:4:"9985";s:53:"Classes/Validation/Validator/DisjunctionValidator.php";s:4:"d964";s:54:"Classes/Validation/Validator/EmailAddressValidator.php";s:4:"0808";s:47:"Classes/Validation/Validator/FloatValidator.php";s:4:"9065";s:55:"Classes/Validation/Validator/GenericObjectValidator.php";s:4:"2712";s:49:"Classes/Validation/Validator/IntegerValidator.php";s:4:"e544";s:50:"Classes/Validation/Validator/NotEmptyValidator.php";s:4:"25e6";s:53:"Classes/Validation/Validator/NumberRangeValidator.php";s:4:"0e64";s:48:"Classes/Validation/Validator/NumberValidator.php";s:4:"5fb6";s:57:"Classes/Validation/Validator/ObjectValidatorInterface.php";s:4:"90d8";s:45:"Classes/Validation/Validator/RawValidator.php";s:4:"6202";s:59:"Classes/Validation/Validator/RegularExpressionValidator.php";s:4:"c03a";s:54:"Classes/Validation/Validator/StringLengthValidator.php";s:4:"6045";s:48:"Classes/Validation/Validator/StringValidator.php";s:4:"ea42";s:46:"Classes/Validation/Validator/TextValidator.php";s:4:"1f58";s:51:"Classes/Validation/Validator/ValidatorInterface.php";s:4:"68f7";s:24:"Documentation/README.txt";s:4:"35d4";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"d03e";s:22:"Tests/BaseTestCase.php";s:4:"9ebe";s:30:"Tests/SeleniumBaseTestCase.php";s:4:"e3b0";s:60:"Tests/Configuration/BackendConfigurationManager_testcase.php";s:4:"dbdd";s:61:"Tests/Configuration/FrontendConfigurationManager_testcase.php";s:4:"b7d5";s:46:"Tests/DomainObject/AbstractEntity_testcase.php";s:4:"4fb8";s:25:"Tests/Fixtures/Entity.php";s:4:"df65";s:52:"Tests/MVC/Controller/AbstractController_testcase.php";s:4:"ff72";s:50:"Tests/MVC/Controller/ActionController_testcase.php";s:4:"9cef";s:42:"Tests/MVC/Controller/Argument_testcase.php";s:4:"edaa";s:43:"Tests/MVC/Controller/Arguments_testcase.php";s:4:"0ed6";s:41:"Tests/MVC/Web/RequestBuilder_testcase.php";s:4:"7cf0";s:29:"Tests/MVC/Web/RequestTest.php";s:4:"0533";s:45:"Tests/MVC/Web/Routing/UriBuilder_testcase.php";s:4:"a229";s:44:"Tests/Persistence/ObjectStorage_testcase.php";s:4:"3513";s:36:"Tests/Persistence/Query_testcase.php";s:4:"144e";s:38:"Tests/Persistence/Session_testcase.php";s:4:"1752";s:52:"Tests/Persistence/Mapper/DataMapFactory_testcase.php";s:4:"f081";s:53:"Tests/Persistence/Storage/Typo3DbBackend_testcase.php";s:4:"f746";s:37:"Tests/Reflection/Service_testcase.php";s:4:"f9ae";s:54:"Tests/Security/Channel/RequestHashService_testcase.php";s:4:"8d6f";s:52:"Tests/Security/Cryptography/HashService_testcase.php";s:4:"3ae2";s:36:"Tests/Utility/Extension_testcase.php";s:4:"ad36";s:37:"Tests/Utility/TypoScript_testcase.php";s:4:"a27c";s:47:"Tests/Validation/ValidatorResolver_testcase.php";s:4:"db32";s:61:"Tests/Validation/Validator/AlphanumericValidator_testcase.php";s:4:"d351";s:60:"Tests/Validation/Validator/ConjunctionValidator_testcase.php";s:4:"5a85";s:57:"Tests/Validation/Validator/DateTimeValidator_testcase.php";s:4:"fc81";s:61:"Tests/Validation/Validator/EmailAddressValidator_testcase.php";s:4:"c8a7";s:54:"Tests/Validation/Validator/FloatValidator_testcase.php";s:4:"571c";s:62:"Tests/Validation/Validator/GenericObjectValidator_testcase.php";s:4:"5c98";s:56:"Tests/Validation/Validator/IntegerValidator_testcase.php";s:4:"7dc5";s:57:"Tests/Validation/Validator/NotEmptyValidator_testcase.php";s:4:"0ad0";s:60:"Tests/Validation/Validator/NumberRangeValidator_testcase.php";s:4:"10fb";s:55:"Tests/Validation/Validator/NumberValidator_testcase.php";s:4:"2ecc";s:52:"Tests/Validation/Validator/RawValidator_testcase.php";s:4:"25ca";s:66:"Tests/Validation/Validator/RegularExpressionValidator_testcase.php";s:4:"e565";s:61:"Tests/Validation/Validator/StringLengthValidator_testcase.php";s:4:"bfc1";s:53:"Tests/Validation/Validator/TextValidator_testcase.php";s:4:"5454";}',
);

?>