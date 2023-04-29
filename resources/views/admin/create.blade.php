

<form action="{{ route('createUserAdmin') }}" method="post">

{{ csrf_field() }}
    <input type="text" name="name" id="" placeholder="name"><br>
    <input type="text" name="telefone" id="" placeholder="telefone"><br>
    <input type="text" name="email" id="" placeholder="email"><br>
    <input type="text" name="username" id="" placeholder="username"><br>
    <input type="submit" value="Enviar"><br>
</form>