<?php
// Zend Frameworkのパスを追加する
$path = "./ZendFramework/library/";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

// 以前はこれでよかったみたい・・・今はダメ
// require_once 'Zend/Loader.php';
// Zend_Loader::registerAutoload();

require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->setFallbackAutoloader(true); 

$user = "upartner0000@gmail.com";
$pass = "up08090326";

$service = Zend_Gdata_Calendar::AUTH_SERVICE_NAME;
$client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);
$serviceCal = new Zend_Gdata_Calendar($client);

// 全削除のサンプル
delCalAll($serviceCal, $user);

// 登録のサンプル
insCal($serviceCal, '2012-11-23', '13:00', '2012-11-23', '16:00', '極秘会議', "出席者：\r\nAさん、Bさん", '第5会議室');

// ************************************************************
// イベント登録
// $sdate, $edate:yyyy-mm-dd
// $stime, $etime:hh:nn
// ************************************************************
function insCal($serviceCal, $sdate, $stime, $edate, $etime, $title, $content, $location){
 // 新規にイベントを作成
 $event= $serviceCal->newEventEntry();

 // イベントの内容を設定
 $event->title = $serviceCal->newTitle($title);
 $event->where = array($serviceCal->newWhere($location));
 $event->content = $serviceCal->newContent($content);
 // 日時の設定
 $when = $serviceCal->newWhen();
 // タイムゾーンは日本(+9:00)
 $tzOffset = "+09";
 $when->startTime = "{$sdate}T{$stime}:00.000{$tzOffset}:00";
 $when->endTime = "{$edate}T{$etime}:00.000{$tzOffset}:00";
 $event->when = array($when);
 
 // イベントをGoogle Calenderに登録
 $newEvent = $serviceCal->insertEvent($event);
 echo "SUCCESS(INSERT).\r\n";
}

// ************************************************************
// 全イベント削除
// ************************************************************
function delCalAll($serviceCal){
 // カレンダーリストを取得
 try {
  $listFeed= $serviceCal->getCalendarListFeed();
 } catch (Zend_Gdata_App_Exception $e) {
  echo "ERROR(DELETE)." . $e->getMessage();
 }
 foreach($listFeed as $list){
  $listId = $list->id;
  $user = substr($listId, strrpos($listId, "/") + 1);
  // イベントリストを取得
  $query = $serviceCal->newEventQuery();
  $query->setUser($user);
  $query->setVisibility('private');
  $query->setProjection('full');
  $query->setOrderby('starttime');
  
  try {
   $eventFeed = $serviceCal->getCalendarEventFeed($query);
  } catch (Zend_GData_App_Exception $e) {
   echo "ERROR(DELETE)." . $e->getMessage();
  }
  
  if($eventFeed){
   foreach($eventFeed as $event) {
    // PHP5?あたりからはemptyで判断。4ならis_nullでもOK
    if(!empty($event->getEditLink()->href)){
     $serviceCal->delete($event->getEditLink()->href);
     echo "SUCCESS(DELETE).\r\n";
    }
   }
  }
 }
}
?>