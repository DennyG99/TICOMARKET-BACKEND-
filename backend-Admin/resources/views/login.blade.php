
<form method="POST">
    @csrf
  <!-- Email input -->
  <div class="form-outline mb-4">
    <input type="email" name="email" id="form2Example1" class="form-control" placeholder="correo"/>
  </div>

  <!-- Password input -->
  <div class="form-outline mb-4">
    <input type="password" name="password" id="form2Example2" class="form-control" placeholder="contraseña"/>
  </div>

  <!-- 2 column grid layout for inline styling -->
  <div class="row mb-4">

  <!-- Submit button -->
  <button type="submit">ingresar</button>

</form>