<?php
/***************************************************************
*  Copyright notice
*  
*  (c) 1999-2003 Kasper Sk�rh�j (kasper@typo3.com)
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
*  A copy is found in the textfile GPL.txt and important notices to the license 
*  from the author is found in LICENSE.txt distributed with these scripts.
*
* 
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/** 
 * Class used in module tools/dbint (advanced search) and which may hold code specific for that module
 * However the class has a general principle in it which may be used in the web/export module.
 *
 * @author	Kasper Sk�rh�j <kasper@typo3.com>
 * @package TYPO3
 * @subpackage t3lib
 */

 
class t3lib_fullsearch {
	var $storeList = "search_query_smallparts,queryConfig,queryTable,queryFields,queryLimit,queryOrder,queryOrderDesc,queryOrder2,queryOrder2Desc,queryGroup,search_query_makeQuery";
	var $downloadScript = "index.php";
	var $formW=48;
	var $noDownloadB=0;
	
	function form()	{
		$out='
		Search Word:<BR>
		<input type="text" name="SET[sword]" value="'.$GLOBALS["SOBE"]->MOD_SETTINGS["sword"].'"'.$GLOBALS["TBE_TEMPLATE"]->formWidth(20).'><input type="submit" name="submit" value="Search All Records">
		';
		
		return $out;
	}
	function makeStoreControl()	{
			// Load/Save
		$storeArray = $this->initStoreArray();
		$cur="";
		
			// Store Array:
		$opt=array();
		reset($storeArray);
		while(list($k,$v)=each($storeArray))	{
			$opt[]='<option value="'.$k.'"'.(!strcmp($cur,$v)?" selected":"").'>'.htmlspecialchars($v).'</option>';
		}
		
			// Actions:
		if (t3lib_extMgm::isLoaded("sys_action"))	{
			$query = "SELECT * FROM sys_action WHERE type=2 ORDER BY title";
			$res = mysql(TYPO3_db,$query);
			if (mysql_num_rows($res))	{
				$opt[]='<option value="0">__Save to Action:__</option>';
				while($row=mysql_fetch_assoc($res))	{
					$opt[]='<option value="-'.$row["uid"].'"'.(!strcmp($cur,"-".$row["uid"])?" selected":"").'>'.htmlspecialchars($row["title"]." [".$row["uid"]."]").'</option>';
				}
			}
		}

		$TDparams=' nowrap bgcolor="'.$GLOBALS["TBE_TEMPLATE"]->bgColor4.'"';
		$tmpCode='
		<table border=0 cellpadding=3 cellspacing=1>
		<tr'.$TDparams.'><td><select name="storeControl[STORE]" onChange="document.forms[0][\'storeControl[title]\'].value= this.options[this.selectedIndex].value!=0 ? this.options[this.selectedIndex].text : \'\';">'.implode(chr(10),$opt).'</select><input type="submit" name="storeControl[LOAD]" value="Load"></td></tr>		
		<tr'.$TDparams.'><td nowrap><input name="storeControl[title]" value="" type="text" max=80'.$GLOBALS["SOBE"]->doc->formWidth().'><input type="submit" name="storeControl[SAVE]" value="Save" onClick="if (document.forms[0][\'storeControl[STORE]\'].options[document.forms[0][\'storeControl[STORE]\'].selectedIndex].value<0) return confirm(\'Are you sure you want to overwrite the existing query in this action?\');"><input type="submit" name="storeControl[REMOVE]" value="Remove"></td></tr>
		</table>
		';
		return $tmpCode;	
	}
	function initStoreArray()	{
		$storeArray=array(
			"0" => "[New]"
		);

		$savedStoreArray = unserialize($GLOBALS["SOBE"]->MOD_SETTINGS["storeArray"]);
		
		if (is_array($savedStoreArray))	{
			$storeArray = array_merge($storeArray,$savedStoreArray);
		}
		return $storeArray;
	}
	function cleanStoreQueryConfigs($storeQueryConfigs,$storeArray)	{
		if (is_array($storeQueryConfigs))	{
			reset($storeQueryConfigs);
			while(list($k,$v)=each($storeQueryConfigs))	{
				if (!isset($storeArray[$k]))	unset($storeQueryConfigs[$k]);
			}
		}
		return $storeQueryConfigs;
	}
	function addToStoreQueryConfigs($storeQueryConfigs,$index)	{
		$keyArr = explode(",",$this->storeList);
		reset($keyArr);
		$storeQueryConfigs[$index]=array();
		while(list(,$k)=each($keyArr))	{
			$storeQueryConfigs[$index][$k]=$GLOBALS["SOBE"]->MOD_SETTINGS[$k];
		}
		return $storeQueryConfigs;
	}
	function saveQueryInAction($uid)	{
		if (t3lib_extMgm::isLoaded("sys_action"))	{
			$keyArr = explode(",",$this->storeList);
			reset($keyArr);
			$saveArr=array();
			while(list(,$k)=each($keyArr))	{
				$saveArr[$k]=$GLOBALS["SOBE"]->MOD_SETTINGS[$k];
			}
	
			$dA=array();
			$qOK=0;
				// Show query				
			if ($saveArr["queryTable"])	{
				$qGen = t3lib_div::makeInstance("t3lib_queryGenerator");
				$qGen->init("queryConfig",$saveArr["queryTable"]);
				$qGen->makeSelectorTable($saveArr);
				
				$qGen->enablePrefix=1;
				$qString = $qGen->getQuery($qGen->queryConfig);
				$qCount = "SELECT count(*) FROM ".$qGen->table." WHERE ".$qString.t3lib_BEfunc::deleteClause($qGen->table);
				$qSelect = $qGen->getSelectQuery($qString);
	
				$res = @mysql(TYPO3_db,$qCount);
				if (!mysql_error())	{
					$dA["t2_data"] = serialize(array(
						"qC"=>$saveArr,
						"qCount" => $qCount,
						"qSelect" => $qSelect,
						"qString" => $qString
					));
	//				debug(unserialize($dA["t2_data"]));
					$qOK=1;
				}
			}
			//$this->tableWrap($qExplain)
			
			$query = t3lib_BEfunc::DBcompileUpdate("sys_action","uid=".intval($uid),$dA);
			$res = mysql(TYPO3_db,$query);
			return $qOK;
		}
	}
	function loadStoreQueryConfigs($storeQueryConfigs,$storeIndex,$writeArray)	{
		if ($storeQueryConfigs[$storeIndex])	{
			$keyArr = explode(",",$this->storeList);
			reset($keyArr);
			while(list(,$k)=each($keyArr))	{
				$writeArray[$k]=$storeQueryConfigs[$storeIndex][$k];
			}
		}
		return $writeArray;
	}
	function procesStoreControl()	{
		$storeArray = $this->initStoreArray();
		$storeQueryConfigs = unserialize($GLOBALS["SOBE"]->MOD_SETTINGS["storeQueryConfigs"]);

		$storeControl = t3lib_div::GPvar("storeControl");
		$storeIndex = intval($storeControl["STORE"]);
		$saveStoreArray=0;
		$writeArray=array();
		if (is_array($storeControl))	{
			$storeControl = t3lib_div::slashArray($storeControl,"strip");
			if ($storeControl["LOAD"])	{
				if ($storeIndex>0)	{
					$writeArray=$this->loadStoreQueryConfigs($storeQueryConfigs,$storeIndex,$writeArray);
					$saveStoreArray=1;
					$msg="'".$storeArray[$storeIndex]."' query loaded!";
				} elseif ($storeIndex<0 && t3lib_extMgm::isLoaded("sys_action"))	{
					$actionRecord=t3lib_BEfunc::getRecord("sys_action",abs($storeIndex));
					if (is_array($actionRecord))	{
						$dA = unserialize($actionRecord["t2_data"]);
						$dbSC=array();
						if (is_array($dA["qC"]))	{
							$dbSC[0] = $dA["qC"];
						}
						$writeArray=$this->loadStoreQueryConfigs($dbSC,"0",$writeArray);
						$saveStoreArray=1;
						$acTitle=htmlspecialchars($actionRecord["title"]);
						$msg="Query from action '".$acTitle."' loaded!";
					}
				}
			} elseif ($storeControl["SAVE"])	{
				if ($storeIndex<0)	{
					$qOK = $this->saveQueryInAction(abs($storeIndex));
					if ($qOK)	{
						$msg="Query OK and saved.";
					} else {
						$msg="No query saved!";
					}
				} else {
					if (trim($storeControl["title"]))	{
						if ($storeIndex>0)	{
							$storeArray[$storeIndex]=$storeControl["title"];
						} else {
							$storeArray[]=$storeControl["title"];
							end($storeArray);
							$storeIndex=key($storeArray);
						}
						$storeQueryConfigs=$this->addToStoreQueryConfigs($storeQueryConfigs,$storeIndex);
						$saveStoreArray=1;
						$msg="'".$storeArray[$storeIndex]."' query saved!";
					}
				}
			} elseif ($storeControl["REMOVE"])	{
				if ($storeIndex>0)	{
					$msg="'".$storeArray[$storeControl["STORE"]]."' query entry removed!";
					unset($storeArray[$storeControl["STORE"]]);	// Removing
					$saveStoreArray=1;
				}
			}
		}
		if ($saveStoreArray)	{
			unset($storeArray[0]);	// making sure, index 0 is not set!
			$writeArray["storeArray"]=serialize($storeArray);
			$writeArray["storeQueryConfigs"]=serialize($this->cleanStoreQueryConfigs($storeQueryConfigs,$storeArray));
			$GLOBALS["SOBE"]->MOD_SETTINGS = t3lib_BEfunc::getModuleData($GLOBALS["SOBE"]->MOD_MENU, $writeArray, $GLOBALS["SOBE"]->MCONF["name"], "ses");
		}
		return $msg;
	}
	function queryMaker()	{
		global $TCA;

		$msg=$this->procesStoreControl();

		$output.= $GLOBALS["SOBE"]->doc->section('Load/Save Query',$this->makeStoreControl(),0,1);
		if ($msg)	{
			$output.= $GLOBALS["SOBE"]->doc->section('','<font color=red><strong>'.$msg.'</strong></font>');
		}
		$output.= $GLOBALS["SOBE"]->doc->spacer(20);


			// Query Maker:
		$qGen = t3lib_div::makeInstance("t3lib_queryGenerator");
		$qGen->init("queryConfig",$GLOBALS["SOBE"]->MOD_SETTINGS["queryTable"]);
		$tmpCode=$qGen->makeSelectorTable($GLOBALS["SOBE"]->MOD_SETTINGS);
		$output.= $GLOBALS["SOBE"]->doc->section('Make query',$tmpCode,0,1);

		$mQ = $GLOBALS["SOBE"]->MOD_SETTINGS["search_query_makeQuery"];

			// Make form elements:
		if ($qGen->table && is_array($TCA[$qGen->table]))	{
			if ($mQ)	{
					// Show query				
				$qGen->enablePrefix=1;
				$qString = $qGen->getQuery($qGen->queryConfig);
//				debug($qGen->queryConfig);
		
				switch($mQ)	{
					case "count":
						$qExplain = "SELECT count(*) FROM ".$qGen->table." WHERE ".$qString.t3lib_BEfunc::deleteClause($qGen->table);
					break;
					default:
//						$qExplain = "SELECT uid,pid,".$TCA[$qGen->table]["ctrl"]["label"]." FROM ".$qGen->table." WHERE ".$qString.t3lib_BEfunc::deleteClause($qGen->table)." LIMIT 100";
						$qExplain = $qGen->getSelectQuery($qString);
						if ($mQ=="explain")	{
							$qExplain="EXPLAIN ".$qExplain;
						}
					break;
				}

				$output.= $GLOBALS["SOBE"]->doc->section('SQL query',$this->tableWrap($qExplain),0,1);

				$res = @mysql(TYPO3_db,$qExplain);
				if (mysql_error())	{
					$out.="<BR><strong>Error:</strong><BR><font color=red><strong>".mysql_error()."</strong></font>";
					$output.= $GLOBALS["SOBE"]->doc->section('SQL error',$out,0,1);
				} else {
					$cPR = $this->getQueryResultCode($mQ,$res,$qGen->table);
					$output.=$GLOBALS["SOBE"]->doc->section($cPR["header"],$cPR["content"],0,1);
				}
			}
		}		
		return $output;
	}
	function getQueryResultCode($mQ,$res,$table)	{
		global $TCA;
		$output="";
		$cPR=array();
		switch($mQ)	{
			case "count":
				$row = mysql_fetch_row($res);
				$cPR["header"]='Count';
				$cPR["content"]="<BR><strong>".$row[0]. "</strong> records selected.";
			break;
			case "all":
				$rowArr=array();
				while($row=mysql_fetch_assoc($res))	{
					$rowArr[]=$this->resultRowDisplay($row,$TCA[$table],$table);
					$lrow=$row;
				}
				if (count($rowArr))	{
					$out.="<table border=0 cellpadding=2 cellspacing=1>".$this->resultRowTitles($lrow,$TCA[$table],$table).implode(chr(10),$rowArr)."</table>";
				}
				if (!$out)	$out="<em>No rows selected!</em>";
				$cPR["header"]='Result';
				$cPR["content"]=$out;
			break;
			case "csv":
				$rowArr=array();
				$first=1;
				while($row=mysql_fetch_assoc($res))	{
					if ($first)	{
						$rowArr[]=$this->csvValues(array_keys($row),",","");
						$first=0;
					}
					$rowArr[]=$this->csvValues($row);
				}
				if (count($rowArr))	{
					$out.='<textarea name="whatever" rows="20" wrap="off"'.$GLOBALS["SOBE"]->doc->formWidthText($this->formW,"","off").'>'.t3lib_div::formatForTextarea(implode(chr(10),$rowArr)).'</textarea>';
					if (!$this->noDownloadB)	{
						$out.='<BR><input type="submit" name="download_file" value="Click to download file" onClick="document.location=\''.$this->downloadScript.'\';">';		// document.forms[0].target=\'_blank\'; 
					}
						// Downloads file:
					if (t3lib_div::GPvar("download_file"))	{
						$filename="TYPO3_".$table."_export_".date("dmy-Hi").".csv";
						$mimeType = "application/octet-stream";
						Header("Content-Type: ".$mimeType);
						Header("Content-Disposition: attachment; filename=".$filename);
						echo implode(chr(13).chr(10),$rowArr);
						exit;
					}
				}
				if (!$out)	$out="<em>No rows selected!</em>";
				$cPR["header"]='Result';
				$cPR["content"]=$out;
			break;
			case "xml":
				$className=t3lib_div::makeInstanceClassName("t3lib_xml");
				$xmlObj = new $className("typo3_export");
				$xmlObj->includeNonEmptyValues=1;
				$xmlObj->renderHeader();
				$first=1;
				while($row=mysql_fetch_assoc($res))	{
					if ($first)	{
						$xmlObj->setRecFields($table,implode(",",array_keys($row)));
		//				debug($xmlObj->XML_recFields);
						$first=0;
					}
					$xmlObj->addRecord($table,$row);
				}
				$xmlObj->renderFooter();
				if (mysql_num_rows($res))	{
					$xmlData=$xmlObj->getResult();
					$out.='<textarea name="whatever" rows="20" wrap="off"'.$GLOBALS["SOBE"]->doc->formWidthText($this->formW,"","off").'>'.t3lib_div::formatForTextarea($xmlData).'</textarea>';
					if (!$this->noDownloadB)	{
						$out.='<BR><input type="submit" name="download_file" value="Click to download file" onClick="document.location=\''.$this->downloadScript.'\';">';		// document.forms[0].target=\'_blank\'; 
					}
						// Downloads file:
					if (t3lib_div::GPvar("download_file"))	{
						$filename="TYPO3_".$table."_export_".date("dmy-Hi").".xml";
						$mimeType = "application/octet-stream";
						Header("Content-Type: ".$mimeType);
						Header("Content-Disposition: attachment; filename=".$filename);
						echo $xmlData;
						exit;
					}
				}
				if (!$out)	$out="<em>No rows selected!</em>";
				$cPR["header"]='Result';
				$cPR["content"]=$out;
			break;
			case "explain":
			default:
				while($row=mysql_fetch_assoc($res))	{
					$out.="<BR>".t3lib_div::view_array($row);
				}
				$cPR["header"]='Explain SQL query';
				$cPR["content"]=$out;
			break;
		}
		return $cPR;
	}
	function csvValues($row,$delim=",",$quote='"')	{
		return t3lib_div::csvValues($row,$delim,$quote);
	}
	function tableWrap($str)	{
		return '<table border=0 cellpadding=10 cellspacing=0 bgcolor="'.$GLOBALS["TBE_TEMPLATE"]->bgColor4.'"><tr><td nowrap><pre>'.$str.'</pre></td></tr></table>';
	}
	function search()	{
		global $TCA;
		$SET = t3lib_div::GPvar("SET");
		$swords = $SET["sword"];
		// $GLOBALS["HTTP_POST_VARS"]["SET"]["sword"]
		$limit=200;
		$showAlways=0;
		if ($swords)	{
			reset($TCA);
			while(list($table)=each($TCA))	{
					// Get fields list
				t3lib_div::loadTCA($table);
				$conf=$TCA[$table];
				
				reset($conf["columns"]);
				$list=array();
				while(list($field,)=each($conf["columns"]))	{
					$list[]=$field;
				}
					// Get query
				$qp = t3lib_BEfunc::searchQuery(array($swords),$list);
				
					// Count:
				$query = "SELECT count(*) FROM ".$table." WHERE ".$qp.t3lib_BEfunc::deleteClause($table);
				$res = mysql(TYPO3_db,$query);
				echo mysql_error();
				list($count)=mysql_fetch_row($res);
				if($count || $showAlways)	{
						// Output header:
					$out.="<strong>TABLE:</strong> ".$GLOBALS["LANG"]->sL($conf["ctrl"]["title"])."<BR>";
					$out.="<strong>Results:</strong> ".$count."<BR>";
	
						// Show to limit
					if ($count)	{
						$query = "SELECT uid,pid,".$conf["ctrl"]["label"]." FROM ".$table." WHERE ".$qp.t3lib_BEfunc::deleteClause($table)." LIMIT ".$limit;
						$res = mysql(TYPO3_db,$query);
						$rowArr=array();
						while($row=mysql_fetch_assoc($res))	{
							$rowArr[]=$this->resultRowDisplay($row,$conf,$table);
							$lrow=$row;
						}
						$out.="<table border=0 cellpadding=2 cellspacing=1>".$this->resultRowTitles($lrow,$conf,$table).implode(chr(10),$rowArr)."</table>";
					}
					$out.="<HR>";
				}
			}
		}
		return $out;
	}
	
	function resultRowDisplay($row,$conf,$table)	{
		$out='<tr bgcolor="'.$GLOBALS["SOBE"]->doc->bgColor4.'">';
		reset($row);
		while(list($fN,$fV)=each($row))	{
			$TDparams = " nowrap";
			$fVnew = t3lib_BEfunc::getProcessedValueExtra($table,$fN,$fV);
			$out.='<td'.$TDparams.'>'.htmlspecialchars($fVnew).'</td>';
		}
		$params = '&edit['.$table.']['.$row["uid"].']=edit';
		$out.='<td nowrap><A HREF="#" onClick="top.launchView(\''.$table.'\','.$row["uid"].',\''.$GLOBALS["BACK_PATH"].'\');return false;"><img src="'.$GLOBALS["BACK_PATH"].'gfx/zoom2.gif" width="12" height="12" border="0" alt=""></a><A HREF="#" onClick="'.t3lib_BEfunc::editOnClick($params,$GLOBALS["BACK_PATH"],t3lib_div::getIndpEnv("REQUEST_URI").t3lib_div::implodeArrayForUrl("SET",$GLOBALS["HTTP_POST_VARS"]["SET"])).'"><img src="'.$GLOBALS["BACK_PATH"].'gfx/edit2.gif" width="11" height="12" border="0" alt=""></a></td>
		</tr>
		';
		return $out;
	}
	function resultRowTitles($row,$conf,$table)	{
		$out='<tr bgcolor="'.$GLOBALS["SOBE"]->doc->bgColor5.'">';
		reset($row);
		while(list($fN,$fV)=each($row))	{
			if (strlen($fV)<50)		{$TDparams = " nowrap";} else {$TDparams = "";}
			$out.='<td'.$TDparams.'><strong>'.$GLOBALS["LANG"]->sL($conf["columns"][$fN]["label"]?$conf["columns"][$fN]["label"]:$fN,1).'</strong></td>';
		}
		$out.='<td nowrap></td>
		</tr>
		';
		return $out;
	}
}


if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["t3lib/class.t3lib_fullsearch.php"])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["t3lib/class.t3lib_fullsearch.php"]);
}

?>