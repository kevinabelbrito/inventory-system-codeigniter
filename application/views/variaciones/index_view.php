<div class="content-layout">
    <div class="content-layout-row">
	    <div class="layout-cell" style="width: 40%" >
	        <?= form_open('variaciones/', array('class' => 'search', 'id' => 'busquedaForm', 'method' => 'get')) ?>
			<?= form_input('campo', $campo, array('id' => 'campo', 'placeholder' => 'Descripción de la variación')) ?><a class="search-button" href="#" onclick="javascript:jQuery(this).parents('form').submit();"><span class="search-button-text">Buscar</span></a>
			<?= form_close() ?>
	    </div>
	    <div class="layout-cell" style="width: 60%" >
	        <p style="text-align: right;">
	        	<a href="#" class="button" data-toggle="modal" data-target="#ModalAgregar"><span class="glyphicon glyphicon-plus-sign"></span> Agregar nueva</a>
		        <a href="<?= base_url() ?>admin" class="button"><span class="glyphicon glyphicon-menu-hamburger"></span> Menú</a>
	        </p>
	    </div>
    </div>
</div>
<div class="content-layout">
    <div class="content-layout-row">
	    <div class="layout-cell" style="width: 100%" >
			<?php if($num_cat > 0){ ?>
			<br>
			<div class="table-responsive">
			<table style="margin: auto;">
				<tr>
					<th>Descripción</th>
					<th>Slug</th>
					<th>Acciones</th>
				</tr>
				<?php foreach ($categorias as $cat): ?>
				<tr>
					<td style="min-width: 150px;"><?= $cat->descripcion ?></td>
					<td style="min-width: 150px;"><?= $cat->slug ?></td>
					<td style="min-width: 150px; text-align: center;">
						<a href="#" class="button" title="Editar" data-toggle="modal" data-target="#ModalEditar<?= $cat->id ?>"><span class="glyphicon glyphicon-edit"></a>
						<a href="#" class="button" title="Eliminar" data-toggle="modal" data-target="#ModalEliminar<?= $cat->id ?>"><span class="glyphicon glyphicon-remove"></a>
					</td>
				</tr>
				<!--Modal Editar-->
				<?php
				$data = array(
					'id' => $cat->id,
					'descripcion' => $cat->descripcion,
					);
				$this->load->view('variaciones/editar_view', $cat);
				?>
				<!--Modal Eliminar-->
				<?php
				$data = array('id' => $cat->id, 'descripcion' => $cat->descripcion, 'slug' => $cat->slug);
				$this->load->view('variaciones/eliminar_view', $cat);
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
			$this->load->view('variaciones/agregar_view');
			?>
	    </div>
    </div>
</div>