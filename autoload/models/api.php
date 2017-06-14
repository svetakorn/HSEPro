<?php


namespace models;

class api{
	
	
	static function getNotifications($id_user){
		$db = \F3::get("DB");
		$notifications = $db->exec("SELECT user_notification.date, notification.name FROM user_notification 
											JOIN notification ON user_notification.id_notification = notification.id
											WHERE user_notification.id_user = $id_user");
		return array("error" => null, "data" => $notifications);
	}

	static function setNotificationInfo($id_user, $id_user_guid){

		$db = \F3::get("DB");
		if($id_user == null || $id_user_guid == null) return array("error" => "1110", "data" => null);
		$rez = $db->exec("SELECT id FROM user_notification_guid WHERE id_user = $id_user AND guid='$id_user_guid'")[0];
		if($rez != null) return array("error" => "1111", "data" => null);

		$db->exec("INSERT INTO user_notification_guid (id_user, guid) VALUES ($id_user, '$id_user_guid')");
		return array("error" => null, "data" => 1);

	}
	
	
}