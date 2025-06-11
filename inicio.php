<div
    class="table-responsive"
>
    <table
        class="table table-bordered"
    >
        <thead>
            <tr>
                <th> ID </th>
                <th>Nombre</th>
                <th>Correo </th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($empleados as $empleado) {?>
            <tr>
                <td scope="row"> <?php echo $empleado->id;?>
                <td><?php echo $empleado->nombre;?></td>
                <td><?php echo $empleado->correo;?></td>
                <td>
                    <div class="btn-group" role="group" aria-label="">
                    <a herf="controlador=empleador&accion=editar&id" <?php echo $empleado->id; ?> class="btn btn-info">Editar</a>
                    <a herf="?controlador=empleador&accion=borrar&id"<?php echo $empleado->id; ?> class="btn btn-danger">Borrar</a>

                    
                        
                    </td>
            </tr>
            <tr>
                <td scope="row"></td>
                <td></td>
                <td></td>
            </tr>
<?php }?>
        </tbody>
    </table>
    <a name="" id="" class="btn btn-succes" herf="?controlador=empleados&accion=crear" role="button">Añadir empleado</a>
</div>
