<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <!-- FORM DAFTAR -->
        <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
            <div class="card w-25">
                <div class="card-header bg-primary d-flex justify-content-center">
                    <strong><span class="text-light">DAFTAR</span></strong>
                </div>
                <div class="card-body">
                    <form action="/daftar/simpan" method="POST">
                        @csrf
                        <div class="form-group w-100">
                            <label>Daftar Sebagai</label>
                            <div class="form-check">
                                <input type="radio" name="role" class="form-check-input" value="Pengguna" checked><Label>Pengguna</Label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="role" class="form-check-input" value="Petugas"><Label>Petugas</Label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="role" class="form-check-input" value="Bank"><Label>Bank Sampah</Label>
                            </div>
                        </div>

                        <div class="form-group w-100">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama" required>
                        </div>

                        <div class="form-group w-100">
                            <label>Nomor Telepon</label>
                            <input type = "number" name="telp" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                             maxlength = "13" class="form-control" placeholder="No Telp" required>
                        </div>

                        <div class="form-group w-100">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" placeholder="Email" required>
                        </div>

                        <div class="form-group w-100">
                            <label>Kata Sandi</label>
                            <input type="password" name="kata_sandi" class="form-control" placeholder="Kata Sandi" required>
                        </div>

                        <div class="form-group w-100">
                            <label>Konfirmasi Kata Sandi</label>
                            <input type="password" name="konfirmasi_kata_sandi" class="form-control" placeholder="Kata Sandi" required>
                        </div>
                    <div class="modal-footer">
                        <a href="/"><button type="button" class="btn btn-secondary">Batal</button></a>
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
