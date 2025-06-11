
<div class="card">
    <div class="card-header">
        Agregar empleado
    </div>
    <div class="card-body">
        <form action="" method="post">
        
        <div class="mb-3">
            <label for="id" class="form-label">ID</label>
            <input readonly type="text"
             class="form-control" value="<?php echo $empleado->id;?>" name="id" id="id" aria-describedby="helpId" placeholder="Id empleado">

         </div>
        
        <div class="mb-3">
            <label for="id" class="form-label">Nombre</label>
            <input required type="text"
             class="form-control" value="<?php echo $empleado->nombre;?>" name="id" id="id" aria-describedby="helpId" placeholder="Id empleado">

         </div>
        
        <div class="mb-3">
            <label for="id" class="form-label">correo</label>
            <input required type="text"
             class="form-control" value="<?php echo $empleado->correo; ?>" name="id" id="id" aria-describedby="helpId" placeholder="Id empleado">
        
        
         </div>
         <input type="" id="" class="btn btn-success" type="submit" value="agregar empleado">
    </div>
</div>
   