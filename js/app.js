/* Pointe les différents éléments du DOM */
const btnRegister = document.getElementById('btn-register')
const btnConnection = document.getElementById('btn-connection')
const spanMessage = document.getElementById('registerSuccess')
const btnAdd = document.getElementById('submit')

/* Premier écouteur qui va permettre d'afficher le formulaire d'inscription sur l'index */
if(btnRegister != null){
btnRegister.addEventListener('click', async () => {

    /* STYLE FORMS REGISTER & CONNECTION */
    const divForm = document.getElementById('forms');
    divForm.style.background = "#f1a9b4";
    divForm.style.padding = "20px";
    divForm.style.borderRadius = "3px";

    await fetch('inscription.php')
        /* Promesse qui va retourner la page */
        .then((response) => {
            return response.text()
        })
        /* Promesse qui va afficher la page et la placer à l'aide du DOM dans la div forms */
        .then((content) => {
            const divRegister = document.getElementById('forms')
            divRegister.innerHTML = content;
        })

    /* Écoute du formulaire d'inscription */
    let form = document.querySelector('#form-register')
    form.addEventListener('submit', (e) => {
        e.preventDefault(); //Prévention du caractère par défaut du bouton. On écoute le bouton avec e
        const myRegisterForm = new FormData(form);
        myRegisterForm.append('id', 'form-register')// Nouvel objet FormData pour récupérer les valeurs du formulaire
        fetch('inscription.php', {
            method: "POST", // Envoie des valeurs
            body: myRegisterForm
        })
            /* Promesse visant à vérifier si la réponse est ok. Si elle l'est, alors on return la réponse au format json */
            .then((resp) =>{
                if(resp.ok){
                    return resp.json();
                }
            })
            /* Promesse visant à afficher un message de réussite ou d'échec de l'inscription */
            .then((contentResp) => {
                if(contentResp['response'] === 'ok'){
                    document.getElementById('registerSuccess').innerHTML = contentResp['reussite'];
                    spanMessage.innerText = contentResp['reussite'];

                }else{
                    document.getElementById('registerSuccess').innerHTML = contentResp['echoue']
                    spanMessage.innerText = contentResp['echoue'];
                }
            })

    })

})
}

const displayNav = async () => {

    let response = await fetch('./includes/header.php?textOnly');
    let headerHTML = await response.text();
    const headerEl = document.querySelector('header');
    headerEl.innerHTML = headerHTML;
};

const removeBodyContent = () => {
    let bodyContent = document.querySelector('body > div');
    bodyContent.innerHTML = "";
};



if(btnConnection != null) {
    btnConnection.addEventListener('click', async () => {
        const divForm = document.getElementById('forms');
        divForm.style.background = "#f1a9b4";
        divForm.style.padding = "20px";
        divForm.style.borderRadius = "3px";

        await fetch('connexion.php')
            .then((response) => {
                return response.text()
            })
            .then((content) => {
                const divConnection = document.getElementById('forms')
                divConnection.innerHTML = content;
                let formConnection = document.querySelector('#form-connection')
                formConnection.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const myConnectionForm = new FormData(formConnection);
                    fetch('connexion.php', {
                        method: "POST",
                        body: myConnectionForm
                    })
                        .then((response_connect) => {
                            if ((response_connect.ok)) {
                                return response_connect.json();
                            }
                        })
                        .then((contentResponse_connect) => {

                            if (contentResponse_connect['reponse'] === "ok") {
                                document.getElementById('registerSuccess').innerHTML = contentResponse_connect['reussite'];
                                spanMessage.innerText = contentResponse_connect['reussite'];
                                window.location.replace("todolist.php");
                                let headerEl = document.querySelector('header');
                                headerEl.setAttribute('connected', '');
                                displayNav();
                                removeBodyContent();

                            } else {
                                document.getElementById('registerSuccess').innerHTML = contentResponse_connect['echoue']
                                spanMessage.innerText = contentResponse_connect['echoue'];
                            }


                        })

                })


            })


    })
}


/* TODO LIST */
const todoForm = document.getElementById('todo-form'); // pointe sur le formulaire
const todoUl = document.getElementById('list-todo'); // pointe sur la div Todo

/* FONCTION D'AFFICHAGE DE LA TODO */
function displayTodo(content) {

    /*  TAG DES ELEMENTS  */
    const todoDone = document.getElementById('done');

    /* CREATION DES ELEMENTS */
    const todoDiv = document.createElement("div");
    const spanCheck = document.createElement("button");
    const todoItem = document.createElement("li");
    const span = document.createElement("span");
    const spanDelete = document.createElement("span");
    const btnDelete = document.createElement("button");
    const dateFinish = document.createElement("span");
    btnDelete.setAttribute('id', content.id) // IMPORTANT!
    spanCheck.setAttribute('id', content.id) // IMPORTANT !

    /* CURSOR */
    btnDelete.style.cursor = "pointer";
    spanCheck.style.cursor = "pointer";

    /* APPEND DES ELEMENTS */
    todoDiv.appendChild(todoItem);
    todoDiv.appendChild(span);
    todoDiv.appendChild(spanCheck)
    todoDiv.appendChild(spanDelete);
    spanDelete.appendChild(btnDelete);
    todoDiv.appendChild(dateFinish);


    /* SI LE STATUT EST EGAL A 0 ALORS ON APPREND A LA DIV "A FAIRE" */
    if(content.status === 0 ){
        todoUl.appendChild(todoDiv);
    }else{
        todoDone.appendChild(todoDiv);
        spanCheck.remove()
    }

    /* AJOUT DES CLASSES */
    // spanCheck.classList.add("check-task")
    todoDiv.classList.add("todoDiv");
    spanDelete.classList.add("btn-delete");
    btnDelete.classList.add("delete");
    spanCheck.classList.add("check");
    span.classList.add("date");
    dateFinish.classList.add("dateFinish");

    /* INNER DES ELEMENTS */
    spanCheck.innerHTML = '<i class="fa-regular fa-square-check"></i>';
    btnDelete.innerHTML = '<i class="fa-solid fa-trash"></i>' /*  */
    todoItem.textContent = content.content;
    span.textContent = content.creation;
    dateFinish.textContent = content.finish;


    /* ECOUTE DE LA DIV POUR CHANGER LES ELEMENTS DE PLACE AU CLIQUE */
    spanCheck.addEventListener('click', (ev) => {
        // on ajoute la classe checked à chaque element cliqué
        ev.target.classList.toggle('checked');
        todoDone.appendChild(ev.target.closest('.todoDiv'));
        spanCheck.remove()
    });

    btnDelete.addEventListener('click', (ev) => {

        deleteTask(content.id);
        todoDiv.remove(ev.target.id)
    })

    spanCheck.addEventListener('click', (evn) => {
        updateTask(content.id);

    })
}

function displayTodos(contents) {
    for (const content of contents) {
        displayTodo(content);
    }
}

function getTasks(){
    //fetch de la page
    fetch("todolist.php?getTodo=all")
        .then((response) => {
            if (response.ok)
            {
                return response.json();
            }
        })
        //then qui va lancer la fonction displayTodos
        .then((contents) => {
            //fonction qui va display toutes les tâches
            displayTodos(contents);

        });

}

//écoute du formulaire d'envoie
todoForm.addEventListener("submit", (e) => {
    e.preventDefault();
    let data = new FormData(todoForm);
    //fetch de la page afin d'envoyer les informations dans la BDD
    fetch("todolist.php", {
        method: "POST",
        body: data,
    })
        //promesse qui va permettre de return un json
        .then((response) => {
            if(response.ok){
                return response.json();
            }
        })
        //promesse qui va enclencher la fonction getTasks()
        .then((content) => {
            displayTodo(content);
            let inputTodo = document.getElementById('input_todo')
            inputTodo.value = "";
        });
});

getTasks();


/* FONCTION POUR DELETE LES TÂCHES */
async function deleteTask(taskId) {
    await fetch(`todolist.php?delete=${taskId}`)
        .then((response) => {
            if (response.ok)
                return response.json();
        })
}

/* FONCTION POUR UPDATE LE STATUS */
async function updateTask(taskId) {
    await fetch(`todolist.php?update=${taskId}`)
        .then((response) => {
            if (response.ok)
                return response.json();
        })
}
