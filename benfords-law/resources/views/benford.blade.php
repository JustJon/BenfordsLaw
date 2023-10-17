<div>
    <!-- Simplicity is an acquired taste. - Katharine Gerould -->
 <h2>Benfords Law Test</h2>

@isset($response)
<div style="font-weight:bold">{{ $response }}</div>
<BR><BR>
@endisset
<form method="POST" action="/benford">
    @csrf
	
<label for="numbers">Enter comma delieated list of integers to test for Benford's Law</label>
<BR> 
<input id="numbers" name="numbers"
    type="text"
    class="@error('numbers') is-invalid @enderror"> 

<button>Submit</button>
<BR><BR>
@error('numbers')
    <div class="alert alert-danger" style="color:red">{{ $message }}</div>
@enderror
</form>

</div>
