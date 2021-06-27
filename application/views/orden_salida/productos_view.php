<?php echo form_open('orden_salida/actualizar_carrito', array('id' => "carrito_compras")); ?>
<div class="table-responsive">
<table cellpadding="6" cellspacing="1" style="width:100%" border="0">

<tr>
        <th>Codigo</th>
        <th style="min-width: 150px;">Nombre</th>
        <th>Cantidad</th>
        <th style="text-align:right;">Item Price</th>
        <th style="text-align:right;">Sub-Total</th>
        <th>Acciones</th>
</tr>

<?php $i = 1; ?>

<?php foreach ($this->cart->contents() as $items): ?>
        
        <input type="hidden" name="<?= $i ?>[rowid]" id="rowid<?= $i ?>" value="<?= $items['rowid'] ?>">
        <tr>  
                <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
                <td style="text-align:center;">
                        <?= $option_value; ?>
                </td>
                <?php endforeach; ?>

                <?php endif; ?>

                <td><?= $items['name']; ?></td>
                <td style="text-align:center; width:50px;">
                <?= $items['qty'] ?>
                </td>
                <td style="text-align:right; min-width: 100px;"><?php echo $this->cart->format_number($items['price']); ?></td>
                <td style="text-align:right; min-width: 150px;">Bs. <?= number_format($items['subtotal'], 2, ",", ".") ?></td>
                <td>
                        <a href="<?= $items['rowid'] ?>" id="eliminar_medic<?= $i ?>" class="button" title="Eliminar"><span class="glyphicon glyphicon-remove"></a>
                </td>
        </tr>

<?php $i++; ?>

<?php endforeach; ?>

<tr>
        <td colspan="4"> </td>
        <td style="text-align:right"><strong>Total</strong></td>
        <td style="text-align:right; min-width: 150px;">Bs. <?= number_format($this->cart->total(), 2, ",", ".")?></td>
</tr>

</table>
</div>
<p class="text-right">
<a href="#" class="button text-right" id="vaciar_carrito">Vaciar Carrito</a>
<a href="#" class="button" id="abonar_todo">Abonar el monto total</a>
</p>
<script>
        $(function () {
                // Ciclo for para boton de eliminar
                for (var i = 1; i <= <?= $i ?>; i++) {
                        $("#eliminar_medic"+i).click(function (e) {
                                var dato = $(this).attr('href');
                                e.preventDefault();
                                $.post("<?= base_url() ?>orden_salida/eliminar_producto/"+dato, dato, function () {
                                        $("#productos").load("<?= base_url() ?>orden_salida/listar_productos");
                                });
                        });
                }
                // Funcion al hacer click en boton de vaciar carrito
                $("#vaciar_carrito").click(function(e){
                        e.preventDefault();
                        var carrito_data = $("#carrito_compras").serialize();
                        $.post("<?= base_url() ?>orden_salida/vaciar_carrito", carrito_data, function (data){
                                if (data == "vaciado")
                                {
                                        $("#productos").load("<?= base_url() ?>orden_salida/listar_productos");
                                }
                        });
                });
                //Accion del boton para abonar todo
                $("#abonar_todo").click(function(e)
                {
                        e.preventDefault();
                        $("#abono").val("<?= $this->cart->total() ?>");
                });
        });
</script>