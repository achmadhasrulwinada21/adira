<h3>Halo, {{ $request->name }} !</h3>
<p>Selamat Datang di {{ $website }}</p>

<table border="0" cellpadding="4" cellspacing="0">
    <thead style="text-align:justify;">
       <tr><th>Nama</th><th>:</th><th>{{ $request->name }}</th></tr>
        <tr><th>Email</th><th>:</th><th>{{ $request->email }}</th></tr>
        <tr><th>Password</th><th>:</th><th>{{ $request->pwd }}</th></tr>   
       </tr>
    </thead>
</table>
 
 