<!DOCTYPE html>
<html>
<head>
<title>User CRUD</title>

<style>
body {
    font-family: Arial;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
}

.container {
    max-width: 800px;
    margin: 40px auto;
    background: white;
    padding: 20px;
    border-radius: 12px;
}

input {
    width: 90%;
    padding: 10px;
    margin-top: 5px;
}

button {
    padding: 8px;
    margin-top: 10px;
    border: none;
    color: white;
    cursor: pointer;
}

.add { background: green; }
.edit { background: orange; }
.delete { background: red; }
.view { background: blue; }

.card {
    background: #eee;
    padding: 10px;
    margin-top: 10px;
}
</style>
</head>

<body>

<div class="container">
    <h2>User Management</h2>

    <button class="add" onclick="openForm()">+ Add User</button>

    <div id="users"></div>
</div>

<!-- FORM MODAL -->
<div id="formBox" style="display:none; background:white; padding:20px; margin:20px;">

    <input type="hidden" id="id">

    <input id="name" placeholder="Name">
    <input id="username" placeholder="Username">
    <input id="email" placeholder="Email">

    <h4>Address</h4>
    <input id="street" placeholder="Street">
    <input id="suite" placeholder="Suite">
    <input id="city" placeholder="City">
    <input id="zipcode" placeholder="Zipcode">

    <h4>Geo</h4>
    <input id="lat" placeholder="Latitude">
    <input id="lng" placeholder="Longitude">

    <button class="add" onclick="saveUser()">Save</button>
    <button onclick="closeForm()">Close</button>
</div>

<script>

// LOAD USERS
function loadUsers(){
    fetch('api.php')
    .then(res => res.json())
    .then(data => {

        let html = '';

        data.forEach(u => {
            html += `
            <div class="card">
                <b>${u.name}</b><br>${u.email}

                <br>
                <button class="view" onclick="viewUser(${u.id})">View</button>
                <button class="edit" onclick="editUser(${u.id})">Edit</button>
                <button class="delete" onclick="deleteUser(${u.id})">Delete</button>
            </div>
            `;
        });

        document.getElementById('users').innerHTML = html;
    });
}

loadUsers();

// OPEN FORM
function openForm(){
    document.getElementById('formBox').style.display = 'block';
    clearForm();
}

// CLOSE FORM
function closeForm(){
    document.getElementById('formBox').style.display = 'none';
}

// CLEAR
function clearForm(){
    document.querySelectorAll("input").forEach(i => i.value = "");
}

// SAVE (INSERT + UPDATE)
function saveUser(){

    let id = document.getElementById('id').value;

    let user = {
        id: id ? parseInt(id) : undefined,
        name: name.value,
        username: username.value,
        email: email.value,
        address: {
            street: street.value,
            suite: suite.value,
            city: city.value,
            zipcode: zipcode.value,
            geo: {
                lat: lat.value,
                lng: lng.value
            }
        }
    };

    fetch('api.php', {
        method: id ? 'PUT' : 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(user)
    })
    .then(res => res.json())
    .then(() => {
        loadUsers();
        closeForm();
        alert("Saved");
    });
}

// EDIT
function editUser(id){
    fetch('api.php?id=' + id)
    .then(res => res.json())
    .then(u => {

        openForm();

        document.getElementById('id').value = u.id;
        name.value = u.name;
        username.value = u.username;
        email.value = u.email;

        street.value = u.address.street;
        suite.value = u.address.suite;
        city.value = u.address.city;
        zipcode.value = u.address.zipcode;

        lat.value = u.address.geo.lat;
        lng.value = u.address.geo.lng;
    });
}

// VIEW
function viewUser(id){
    fetch('api.php?id=' + id)
    .then(res => res.json())
    .then(u => {
        alert(JSON.stringify(u, null, 2));
    });
}

// DELETE
function deleteUser(id){
    if(confirm("Delete?")){
        fetch('api.php?id=' + id, { method:'DELETE' })
        .then(() => loadUsers());
    }
}

</script>

</body>
</html>