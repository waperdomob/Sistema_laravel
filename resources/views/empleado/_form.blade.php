    <h1>{{ $modo }} Empleado</h1>

    @if (count($errors)>0)
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach               
            </ul>
        </div>
    @endif
    <div class="form-group">

        <label for="name">Nombre</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ isset($empleado->name)?$empleado ->name:old('name') }}">
    </div>
    <div class="form-group">
        <label for="lastname">Apellido</label>
        <input type="text" name="lastname" id="lastname" class="form-control" value="{{ isset($empleado->lastname)?$empleado ->lastname:old('lastname') }}">
    </div>
    <div class="form-group">
        <label for="email">Correo Electronico</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ isset($empleado->email)?$empleado ->email:old('email') }}">
    </div>
    <div class="form-group">
        <label for="category_id" >Categoria</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="">Seleccione</option>
           @foreach ($categories as $id => $name)
               <option value="{{$id}}"            
                @if ($id === $empleado->category_id) selected @endif>   
                {{$name}}</option>
           @endforeach  
        </select>
    </div>
    <div class="form-group">
        <label for="photo" ></label>
        @if (isset($empleado->photo))
            <img src="{{  asset(('storage').'/'.$empleado->photo)}}"   whidth="100" height="100" >
        @endif    
        <input type="file" class="form-control" name="photo" id="photo" value=""><br>
    </div>
    <button class="btn btn-success">Enviar</button>

    <a href="{{route('empleado.index')}}" class="btn btn-primary">REGRESAR</a>

