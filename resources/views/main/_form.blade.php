@csrf
<div class="card-body">
    <div class="mb-4">
        <div class="form-group mb-4 text-left">
            <label for="name" class="form-control-label text-primary">Nombre</label>
            <input id="name" name="name" for="name" value="" class="form-control border-top-0 border-end-0 border-start-0 border-primary" aria-label="First Name..." type="text" >
        </div>
    </div>
    <div class="mb-4">
        <div class="form-group text-left">
            <label for="email" class="form-control-label text-primary">Correo electronico</label>
            <input id="email" name="email" type="email" value="" class="form-control border-top-0 border-end-0 border-start-0 border-primary">
        </div>
    </div>
    <div class="mb-4">
        <div class="form-group text-left">
            <label class="form-control-label text-primary">Asistentes</label>
            <select id="asistente" name="asistente" class="form-select" aria-label="Default select example">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-gold btn-fill">{{ $btnText }}</button>
        </div>
    </div>
</div>