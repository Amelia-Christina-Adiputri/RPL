@extends('layouts.main')
@section('title','Ubah Data Diri')
@section('content')

    <!-- NAVIGASI -->
    <div class="col-md-2 border">
        @include('layouts.petugas_navigasi')
    </div>

    <!-- BODY -->
    <div class="col-md-10">

        <!-- JUDUL -->
        <h1>UBAH DATA DIRI</h1>

        <!-- FORM UBAH DATA DIRI -->
        <div class="card">
            <div class="card-body">
                <form action="/petugas_ubah_data_diri/update" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group w-50">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{$petugas->nama}}">
                    </div>

                    <div class="form-group w-50">
                        <label>Alamat</label>
                        <input type="area" name="alamat" class="form-control" value="{{$petugas->alamat}}">
                    </div>

                    <div class="form-group w-25">
                        <label>Nomor Telpon</label>
                        <input type = "number" name="telp" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength = "13" class="form-control" placeholder="No Telp" value="{{$petugas->telp}}">
                    </div>
                    <div class="form-group w-25">
                        <label>Kapasitas</label>
                        <input type="text" name="kapasitas" class="form-control" value="{{$petugas->kapasitas_petugas}}">
                    </div>
                    <div class="form-group w-25">
                        <label>Tarif</label>
                        <input type="text" name="tarif" class="form-control" value="{{$petugas->tarif_petugas}}">
                    </div>
                    <div class="form-group w-25">
                        <label>Latitude</label>
                        <input id="lat" type="text" name="latitude" class="form-control" value="{{$petugas->latitude}}">
                    </div>
                    <div class="form-group w-25">
                        <label>Longitude</label>
                        <input id="lng" type="text" name="longitude" class="form-control" value="{{$petugas->longitude}}">
                    </div>
                    <div>
                        <label>Lokasi</label>
                    </div>
                    <div>
                        <div id="map" style="height: 250px"></div>
                    </div>
                <div class="card-body">
                    <a href="/petugas_data_diri" type="button" class="btn btn-secondary">Batal</a>
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

    var bankIcon = L.icon({
        iconUrl: 'https://cdn1.iconfinder.com/data/icons/logistics-delivery-set-3/512/32-512.png',
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
    var locations = <?php echo json_encode($petugas); ?>;
    console.log(locations);
    if(locations.latitude != null && locations.longitude != null)
    {
        // looping for create marker per location
        marker = L.marker([locations.latitude, locations.longitude], {icon : myIcon}).addTo(map).bindPopup("You're Here!").openPopup();
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
        marker = L.marker([event.latlng.lat, event.latlng.lng], {icon : myIcon}).addTo(map).bindPopup("You're Here!").openPopup();
        map.setView([event.latlng.lat, event.latlng.lng], 18);

        lat.value = event.latlng.lat;
        lng.value = event.latlng.lng;
    })
</script>
@endsection
