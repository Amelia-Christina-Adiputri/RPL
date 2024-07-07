@extends('layouts.main')
@section('title','Ubah Data Diri')
@section('content')

    <!-- NAVIGASI -->
    <div class="col-md-2 border">
        @include('layouts.bank_navigasi')
    </div>

    <!-- BODY -->
    <div class="col-md-10">

        <!-- FORM UBAH DATA DIRI -->
        <br>
        <div class="card">
            <div class="card-header">
                <h5>Ubah Data Diri</h5>
            </div>
            <div class="card-body">
                <form action="/bank_ubah_data_diri/update/{{$bank->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group w-50">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{$bank->nama}}">
                    </div>

                    <div class="form-group w-50">
                        <label>Alamat</label>
                        <input type="area" name="alamat" class="form-control" value="{{$bank->alamat}}">
                    </div>

                    <div class="form-group w-25">
                        <label>E-mail</label>
                        <input type="email" name="email" class="form-control" value="{{$bank->email}}">
                    </div>

                    <div class="form-group w-25">
                        <label>Nomor Telpon</label>
                        <input type = "number" name="telp" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength = "13" class="form-control" placeholder="No Telp" value="{{$bank->telp}}">
                    </div>

                    <div class="form-group w-25">
                        <label>Kapasitas Organik</label>
                        <input type="number" name="kapasitas_organik" class="form-control" value="{{$bank->kapasitas_organik_bank}}">
                    </div>

                    <div class="form-group w-25">
                        <label>Kapasitas Anorganik</label>
                        <input type="number" name="kapasitas_anorganik" class="form-control" value="{{$bank->kapasitas_anorganik_bank}}">
                    </div>

                    <div class="form-group w-25">
                        <label>Latitude</label>
                        <input id="lat" type="text" name="latitude" class="form-control" value="{{$bank->latitude}}">
                    </div>
                    <div class="form-group w-25">
                        <label>Longitude</label>
                        <input id="lng" type="text" name="longitude" class="form-control" value="{{$bank->longitude}}">
                    </div>

                    <div>
                        <label>Lokasi</label>
                    </div>
                    <div>
                        <div id="map" style="height: 250px"></div>
                    </div>
                <div class="card-body">
                    <a href="/bank_data_diri"><button type="button" class="btn btn-secondary">Batal</button></a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('maps')
<script>
    // CUSTOM MARKER
    var myIcon = L.icon({
        iconUrl: 'https://cdn0.iconfinder.com/data/icons/perfico-basic-essentials/64/Pin-512.png',
        iconSize: [50, 50],
        iconAnchor: [25, 50],
        popupAnchor: [-3, -60]
    });

    var petugasIcon = L.icon({
        iconUrl: 'https://cdn1.iconfinder.com/data/icons/logistics-delivery-set-3/512/29-512.png',
        iconSize: [50, 50],
        iconAnchor: [25, 50],
        popupAnchor: [-3, -60]
    });

    var penggunaIcon = L.icon({
        iconUrl: 'https://cdn1.iconfinder.com/data/icons/logistics-delivery-set-3/512/30-512.png',
        iconSize: [50, 50],
        iconAnchor: [25, 50],
        popupAnchor: [-3, -60]
    });

    // Initialize the map
    var map = L.map('map').setView([0, 0], 30);

    // Add a basemap (e.g., OpenStreetMap)
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Add a marker to the all destinations
    var locations = <?php echo json_encode($bank); ?>;

    // console.log(locations);
    if(locations.latitude != null && locations.longitude != null)
    {
        // looping for create marker per location
        marker = L.marker([locations.latitude, locations.longitude], {icon : myIcon}).addTo(map).bindPopup(locations.nama).openPopup();
        map.setView([locations.latitude, locations.longitude], 18);
    }else{
        // Get the user's geolocation and add a marker
        navigator.geolocation.getCurrentPosition(function(position) {
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;
        map.setView([lat, lon], 18);
        marker = L.marker([lat, lon], {icon : myIcon}).addTo(map);
        marker.bindPopup('You are here!').openPopup();
    });
    }

    // Got Longitute & Latitude
    map.on('click', (event)=>{
        if(marker != null){
            map.removeLayer(marker);
        }
        marker = L.marker([event.latlng.lat, event.latlng.lng], {icon : myIcon}).addTo(map).bindPopup(locations.nama).openPopup();
        map.setView([event.latlng.lat, event.latlng.lng], 18);

        lat.value = event.latlng.lat;
        lng.value = event.latlng.lng;
    })
</script>
@endsection
