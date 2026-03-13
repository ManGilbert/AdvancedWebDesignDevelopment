fetch("api.php")
.then(response => response.json())
.then(data => {

    let list = document.getElementById("users");

    data.forEach(user => {
        let li = document.createElement("li");
        li.textContent = user.name + " - " + user.email;
        list.appendChild(li);
    });

})
.catch(error => console.log(error));