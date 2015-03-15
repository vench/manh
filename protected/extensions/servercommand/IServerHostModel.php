<?php
 

/**
 *
 * @author vench
 */
interface IServerHostModel {
    
    function setPort($port);
    function getPort();
    function setIP($ip);
    function getIP();    
    function setFileConf($fileConf);
    function getFileConf();    
    function setServerAdmin($serverAdmin);
    function getServerAdmin();
    function setServerName($serverName);
    function getServerName();
    function setServerAlias($serverAlias);
    function getServerAlias();    
    function setDocumentRoot($documentRoot);
    function getDocumentRoot();    
    function setErrorLog($errorLog);
    function getErrorLog();
    function setCustomLog($customLog);
    function getCustomLog();
  
}
