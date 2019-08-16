<?php
	class Utils{
		public function __construct(){
			date_default_timezone_set('America/Sao_Paulo');
		}

		public function getData(){
			return date('d/m/Y');
		}

		public function getFullData(){
			return date('d/m/Y H:i');
		}

		public function getFullDataWithSeconds(){
			return date('d/m/Y H:i:s');
		}

		public function getHora(){
			return date('H:i');
		}

		public function getHoraWithSeconds(){
			return date('H:i:s');
		}

		public static function alert($type, $msg){
			echo "<div class='alert alert-{$type}'>{$msg}</div>";
		}

		public static function swAlert($type, $title, $msg){
        echo "<script type='text/javascript'>
                Swal.fire({
                    type: '$type',
                    title: '$title',
                    text: '$msg',
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>";
    	}

    	public static function redirect($time, $url){
    		echo "<META http-equiv='refresh' content='{$time};URL={$url}'>";
    	}
	}
?>