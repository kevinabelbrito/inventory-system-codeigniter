<div class="content-layout">
    <div class="content-layout-row">
	    <div class="layout-cell" style="width: 40%" >
	        <?= form_open('usuarios/', array('class' => 'search', 'id' => 'busquedaForm', 'method' => 'get')) ?>
			<?= form_input('campo', $campo, array('id' => 'campo', 'placeholder' => 'Cedula, Nombre o Usuario')) ?><a class="search-button" href="#" onclick="javascript:jQuery(this).parents('form').submit();"><span class="search-button-text">Buscar</span></a>
			<?= form_close() ?>
	    </div>
	    <div class="layout-cell" style="width: 60%" >
	        <p style="text-align: right;">
	        	<?php if($this->session->userdata('tipo') == "Administrador"): ?>
	        	<a href="#" class="button" data-toggle="modal" data-target="#ModalAgregar"><span class="glyphicon glyphicon-plus-sign"></span> Agregar nuevo</a>
	        	<?php endif ?>
		        <a href="<?= base_url() ?>admin" class="button"><span class="glyphicon glyphicon-menu-hamburger"></span> Menú</a>
	        </p>
	    </div>
    </div>
</div>
<div class="content-layout">
    <div class="content-layout-row">
	    <div class="layout-cell" style="width: 100%" >
			<?php if($num_users > 0){ ?>
			<br>
			<div class="table-responsive">
			<table style="margin: auto;">
				<tr>
					<th>Cedula</th>
					<th>Nombre Completo</th>
					<th>Correo Electrónico</th>
					<th>Usuario</th>
					<th>Tipo</th>
					<th>Acciones</th>
				</tr>
				<?php foreach ($usuarios as $user): ?>
				<tr <?php if($this->session->userdata('id') == $user->id): ?> class="bg-primary" <?php endif ?>>
					<td><?= $user->cedula ?></td>
					<td style="min-width: 200px;"><?= $user->nombre ?></td>
					<td><?= $user->email ?></td>
					<td><?= $user->username ?></td>
					<td><?= $user->tipo ?></td>
					<td style="min-width: 150px; text-align: center;">
						<?php if($this->session->userdata('id') != $user->id && $this->session->userdata('tipo') == "Administrador"): ?>
							<a href="#" class="button" title="Editar" data-toggle="modal" data-target="#ModalEditar<?= $user->id ?>"><span class="glyphicon glyphicon-edit"></a>
							<a href="#" class="button" title="Eliminar" data-toggle="modal" data-target="#ModalEliminar<?= $user->id ?>"><span class="glyphicon glyphicon-remove"></a>
						<?php else: ?>
						<span class="label label-danger">No Permitido</span>
						<?php endif?>
					</td>
				</tr>
				<!--Modal Editar-->
				<?php
				$data = array(
					'id' => $user->id,
					'cedula' => $user->cedula,
					'nombre' => $user->nombre,
					'email' => $user->email,
					'username' => $user->username,
					'tipo' => $user->tipo,
					'preg' => $user->preg,
					'resp' => $user->resp,
					'preguntas' => $preguntas,
					'tipos' => $tipos,
					);
				$this->load->view('usuarios/editar_view', $data);
				?>
				<!--Modal Eliminar-->
				<?php
				$data = array('id' => $user->id, 'nombre' => $user->nombre);
				$this->load->view('usuarios/eliminar_view', $data);
				?>
				<?php endforeach ?>
			</table>
			</div>
			<?= $pagination ?>
			<?php } else { ?>
			<div class="alert alert-info">
				<h2 class="text-center">No se encontraron usuarios</h2>
			</div>
			<?php } ?>
			<!--Modal para agregar registros-->
			<?php $this->load->view('usuarios/agregar_view', array('preguntas' => $preguntas, 'tipos' => $tipos)); ?>
	    </div>
    </div>
</div>
