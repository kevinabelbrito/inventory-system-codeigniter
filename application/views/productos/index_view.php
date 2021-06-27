<div class="content-layout">
    <div class="content-layout-row">
	    <div class="layout-cell" style="width: 40%" >
	        <?= form_open('productos/', array('class' => 'search', 'id' => 'busquedaForm', 'method' => 'get')) ?>
			<?= form_input('campo', $campo, array('id' => 'campo', 'placeholder' => 'Codigo o Nombre')) ?><a class="search-button" href="#" onclick="javascript:jQuery(this).parents('form').submit();"><span class="search-button-text">Buscar</span></a>
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
			<?php if($num_medicamentos > 0){ ?>
			<br>
			<div class="table-responsive">
			<table style="margin: auto;">
				<tr>
					<th>Código</th>
					<th>Nombre</th>
					<th>Categoría</th>
					<th>Precio (Bs.)</th>
					<th>Stock</th>
					<th>Acciones</th>
				</tr>
				<?php foreach ($medicamentos as $medic): ?>
				<tr>
					<td><?= $medic->codigo ?></td>
					<td style="min-width: 200px;"><?= $medic->nombre ?></td>
					<td><?= $medic->descripcion ?></td>
					<td><?= number_format($medic->precio, 2, ",", ".") ?></td>
					<td><?= $medic->stock ?></td>
					<td style="min-width: 150px; text-align: center;">
						<a href="#" class="button" title="Editar" data-toggle="modal" data-target="#ModalEditar<?= $medic->id ?>"><span class="glyphicon glyphicon-edit"></a>
						<a href="#" class="button" title="Eliminar" data-toggle="modal" data-target="#ModalEliminar<?= $medic->id ?>"><span class="glyphicon glyphicon-remove"></a>
					</td>
				</tr>
				<!--Modal Editar-->
				<?php
				$data = array(
					'id' => $medic->id,
					'codigo' => $medic->codigo,
					'nombre' => $medic->nombre,
					'categoria' => $medic->id_categoria,
					'precio' => $medic->precio,
					'stock' => $medic->stock,
					'categorias' => $categorias,
					);
				$this->load->view('productos/editar_view', $data);
				?>
				<!--Modal Eliminar-->
				<?php
				$data = array('id' => $medic->id, 'nombre' => $medic->nombre);
				$this->load->view('productos/eliminar_view', $data);
				?>
				<?php endforeach ?>
			</table>
			</div>
			<?= $pagination ?>
			<?php } else { ?>
			<div class="alert alert-info">
				<h2 class="text-center"><?= $mensaje ?></h2>
			</div>
			<?php } ?>
			<!--Modal para agregar registros-->
			<?php
			$data = array(
				'categorias' => $categorias,
				);
			$this->load->view('productos/agregar_view', $data);
			?>
	    </div>
    </div>
</div>