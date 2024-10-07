console.log("content.js loaded");

chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {
    if (request.action === "ping") {
        sendResponse({result: "pong"});
    } else if (request.action === "fillFormFields") {
        fillFormFields(request.item);
        sendResponse({result: "success"});
    }
});


function fillFormFields(item) {
    const inputs = document.getElementsByTagName('input');
    let foundInputs = [];
    let userNameFilled = false;

    for (let input of inputs) {
        if (input.type === 'hidden') {
            continue; // Omitir campos de tipo hidden
        }

        if (!userNameFilled && (input.name === 'mail' || input.type === 'email' || input.type === 'text')) {
            input.value = item.user_name;
            foundInputs.push(`User Name: name="${input.name}", type="${input.type}"`);
            userNameFilled = true; // Marcar que el primer campo adecuado ya fue llenado
        } else if (input.name === 'password' || input.type === 'password') {
            input.value = item.password;
            foundInputs.push(`Password: name="${input.name}", type="${input.type}"`);
        }
    }

    if (foundInputs.length === 0) {
        console.warn('No se encontraron los campos necesarios en el formulario.');
    } else {
        console.log(`Campos encontrados y completados:\n${foundInputs.join('\n')}`);
    }
}
