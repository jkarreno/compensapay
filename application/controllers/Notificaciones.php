<?php
	defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
	
	class Notificaciones extends MY_Loggedin {
		/**
		 * Index Page for this controller.
		 *
		 * Maps to the following URL
		 *        http://example.com/index.php/welcome
		 *    - or -
		 *        http://example.com/index.php/welcome/index
		 *    - or -
		 * Since this controller is set as the default controller in
		 * config/routes.php, it's displayed at http://example.com/
		 *
		 * So any other public methods not prefixed with an underscore will
		 * map to /index.php/welcome/<method_name>
		 * @see https://codeigniter.com/userguide3/general/urls.html
		 */
		function __construct () {
			
			parent:: __construct ();
			$this->load->model ( 'Notification_model' );
		}
		public function index () {
			$dato = [
				"noti" => $this->Notification_model->verNotificaciones (),
				"dump" => 0,
			];
			$data[ 'main' ] = $this->load->view ( 'notificaciones', $dato, TRUE );
			$this->load->view ( 'plantilla', $data );
		}
		public function updatenot ( $idnoti ) {
			$dato = [
				"noti" => $this->Notification_model->updateNoti ( $idnoti ),
			];
			$this->load->view ( 'notificacion', $dato );
		}
		
		public function ShowAlerts (){
			$dato = [
				"noti" => $this->Notification_model->verNotificaciones (),
				"dump" => 0,
			];
			$data[ 'main' ] = $this->load->view ( 'alerts', $dato, TRUE );
			$this->load->view ( 'plantilla', $data );
		}
	}
