@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="mb-4">Studi Kasus 3 - Axios Request</h3>

    <a href="{{ url('/ajax-lab') }}" class="btn btn-secondary mb-4">
        ← Kembali
    </a>

    <div class="card">
        <div class="card-body">

            <button class="btn btn-primary mb-3" onclick="loadUsers()">
                Load Users
            </button>

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                    </tr>
                </thead>

                <tbody id="tableUser">
                    <tr>
                        <td colspan="2" class="text-center">Belum ada data</td>
                    </tr>
                </tbody>

            </table>

        </div>
    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
function loadUsers(){
    axios.get('/axios-user')
    .then(function(response){
        let data = response.data;
        let html = '';
        data.forEach(function(user){
            html += `
                <tr>
                    <td>${user.nama}</td>
                    <td>${user.email}</td>
                </tr>
            `;
        });
        document.getElementById("tableUser").innerHTML = html;
    })
    .catch(function(error){
        alert("Terjadi error");
    });
}
</script>

@endsection