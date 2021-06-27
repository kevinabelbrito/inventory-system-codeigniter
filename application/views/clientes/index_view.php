<div class="content-layout">
    <div class="content-layout-row">
	    <div class="layout-cell" style="width: 40%" >
	        <?= form_open('clientes/', array('class' => 'search', 'id' => 'busquedaForm', 'method' => 'get')) ?>
			<?= form_input('campo', $campo, array('id' => 'campo', 'placeholder' => 'Cedula/RIF o Nombre/Razon social')) ?><a class="search-button" href="#" onclick="javascript:jQuery(this).parents('form').submit();"><span class="search-button-text">Buscar</span></a>
			<?= form_close() ?>
	    </div>
	    <div class="layout-cell" style="width: 60%" >
	        <p style="text-align: right;">
	        	<a href="#" class="button" data-toggle="modal" data-target="#ModalAgregar"><span class="glyphicon glyphicon-plus-sign"></span> Agregar nuevo</a>
		        <a href="<?= base_url() ?>admin" class="button"><span class="glyphicon glyphicon-menu-hamburger"></span> Menú</a>
	        </p>
	    </div>
    </div>
</div>
<div class="content-layout">
    <div class="content-layout-row">
	    <div class="layout-cell" style="width: 100%" >
	        <?php if($num_clientes > 0){ ?>
			<br>
			<div class="table-responsive">
			<table style="margin: auto;">
				<tr>
					<th>Cedula/RIF</th>
					<th>Nombre/Razón Social</th>
					<th>Teléfono</th>
					<th>Correo Electrónico</th>
					<th>Dirección</th>
					<th>Acciones</th>
				</tr>
				<?php foreach ($clientes as $cliente): ?>
				<tr>
					<td><?= $cliente->documento ?></td>
					<td><?= $cliente->nombre ?></td>
					<td><?= $cliente->tlf ?></td>
					<td><?= $cliente->email ?></td>
					<td style="min-width: 200px;"><?= $cliente->direccion ?></td>
					<td style="min-width: 150px; text-align: center;">
						<a href="#" class="button" title="Editar" data-toggle="modal" data-target="#ModalEditar<?= $cliente->id ?>"><span class="glyphicon glyphicon-edit"></a>
						<?php if($this->session->userdata('tipo') == "Administrador"): ?>
						<a href="#" class="button" title="Eliminar" data-toggle="modal" data-target="#ModalEliminar<?= $cliente->id ?>"><span class="glyphicon glyphicon-remove"></a>
						<?php endif ?>
					</td>
				</tr>
				<!--Modal Editar-->
				<?php
				$data = array(
					'id' => $cliente->id,
					'nombre' => $cliente->nombre,
					'documento' => $cliente->documento,
					'tlf' => $cliente->tlf,
					'email' => $cliente->email,
					'direccion' => $cliente->direccion,
					);
				$this->load->view('clientes/editar_view', $data);
				?>
				<!--Modal Eliminar-->
				<?php
				$data = array('id' => $cliente->id, 'nombre' => $cliente->nombre);
				$this->load->view('clientes/eliminar_view', $data);
				?>
				<?php endforeach ?>
			</table>
			</div>
			<?= $pagination ?>
			<?php } else { ?>
			<div class="alert alert-info">
				<h2 class="text-center">No se encontraron clientes</h2>
			</div>
			<?php } ?>
			<!--Modal para agregar registros-->
			<?php $this->load->view('clientes/agregar_view'); ?>
			<!--Modal Editar-->
	    </div>
    </div>
</div>
<script>
	$(function(){
		//Eventos del modal
		$('#ModalAgregar').on('hidden.bs.modal', function (e) {
		  window.location="<?= base_url() ?>clientes";
		});
	})
</script>