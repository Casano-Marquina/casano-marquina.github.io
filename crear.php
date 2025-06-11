<div class="card">
    <div class="card-header">
        agregar empleado
    </div>
    <div class="card-body">
        <form action="" method="post">
        <div class="mb-3">
            <label for="" class="form-label">Nombre</label>
            <input
                required type="text"
                class="form-control"
                name=""
                id=""
                aria-describedby="helpId"
                placeholder=""
            />
            
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Correo</label>
            <input
               required type="email"
                class="form-control"
                name="correo"
                id="correo"
                aria-describedby="emailHelpId"
                placeholder="abc@mail.com"
            />
            <small id="emailHelpId" class="form-text text-muted"
                >Help text</small
            >
        </div>
        <input
            name=""
            id=""
            class="btn btn-success"
            type="submit"
            value="editar empleado"
        />
        <a href="?controlador=empleador&accion=inicio" class="btn btn-primary">Cancelar</a>
        </form>

    </div>
    
</div>
