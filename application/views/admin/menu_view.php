<div class="content-layout">
	<div class="content-layout-row">
		<div class="layout-cell" style="width:100%">
			<p style="text-align: right;">
				<a href="#" class="button" data-toggle="modal" data-target="#ModalEditar"><span class="glyphicon glyphicon-user"></span> <?= $this->session->userdata('username') ?></a>
				<a href="#" class="button" data-toggle="modal" data-target="#ModalClave"><span class="glyphicon glyphicon-lock"></span> Cambiar Contraseña</a>
				<a href="#" class="button" data-toggle="modal" data-target="#ModalLogout"><span class="glyphicon glyphicon-off"></span> Logout</a>
			</p>
		</div>
	</div>
</div>
<div class="content-layout">
	<div class="content-layout-row">
		<div class="layout-cell" style="width: 100%" >
			<div class="row">
				<div class="col-sm-4 col-xs-12 text-center">
					<a href="<?= base_url() ?>clientes">
						<h1>Clientes</h1>
						<img alt="clientes" src="<?= base_url() ?>assets/images/clients.png">
					</a>
				</div>
				<div class="col-sm-4 col-xs-12 text-center">
					<a href="<?= base_url() ?>productos">
						<h1>Productos</h1>
						<img width="128" height="128" alt="productos" src="<?= base_url() ?>assets/images/productos.jpg">
					</a>
				</div>
				<div class="col-sm-4 col-xs-12 text-center">
					<a href="<?= base_url() ?>categorias">
						<h1>Categorias</h1>
						<img alt="categorias" src="<?= base_url() ?>assets/images/shopping_cart.png">
					</a>
				</div>
			</div>
	    </div>
	</div>
</div>
<div class="content-layout">
	<div class="content-layout-row">
		<div class="layout-cell" style="width: 100%" >
	        <div class="row">
	        	<div class="col-sm-6 col-xs-12 text-center">
	        		<a href="<?= base_url() ?>orden_salida">
						<h1>Orden de Salida</h1>
						<img alt="orden_salida" src="<?= base_url() ?>assets/images/inventory_maintenance.png">
					</a>
	        	</div>
	        	<div class="col-sm-6 col-xs-12 text-center">
	        		<a href="<?= base_url() ?>usuarios">
						<h1>Usuarios</h1>
						<img alt="usuarios" src="<?= base_url() ?>assets/images/man_black.png">
					</a>
	        	</div>
	        	<!--<div class="col-sm-4 col-xs-12 text-center">
	        		<a href="<?= base_url() ?>perfil_empresa">
						<h1>Configuración</h1>
						<img alt="configuracion" src="<?= base_url() ?>assets/images/config.png">
					</a>
	        	</div>-->
	        </div>
	    </div>
	</div>
</div>
<!--Modal Logout-->
<?php $this->load->view('admin/logout_view'); ?>
<!--Modal Editar-->
<?php $this->load->view('admin/editar_view', array('preguntas' => $preguntas)); ?>
<!--Modal Clave-->
<?php $this->load->view('admin/cambio_clave_view') ?>