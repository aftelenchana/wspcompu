window.onload = function() {
    const usernameCookie = document.cookie.split('; ').find(row => row.startsWith('username='));
    const authTokenCookie = document.cookie.split('; ').find(row => row.startsWith('authToken='));
    const username = usernameCookie ? usernameCookie.split('=')[1] : null;
    const authToken = authTokenCookie ? authTokenCookie.split('=')[1] : null;

    if (username && authToken) {
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('session-info').innerHTML = `Sesión iniciada por ${username} <button id="logout">Cerrar sesión</button>`;

        document.getElementById('salida_buscador').innerHTML = `<form id="buscador"><div class="mb-3"><label for="search" class="guibis-form-label">Buscador</label><input type="text" class="guibis-form-control" id="search" name="search" required></div></form>`;
        document.getElementById('logout').addEventListener('click', function() {
            document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            document.cookie = "authToken=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            location.reload();
        });

        chrome.tabs.query({ active: true, currentWindow: true }, (tabs) => {
            const domain = new URL(tabs[0].url).hostname;
            document.getElementById('informacion_dominio_analizar').innerHTML = `${domain}`;
            fetch('https://guibis.com/api/user_password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    authToken: authToken,
                    domain: domain
                })
            })
            .then(response => response.json())
            .then(data => {
                displayData(data);
                console.log(data);
            })
            .catch(error => console.error('Error:', error));
            chrome.tabs.query({active: true, currentWindow: true}, function(tabs) {
                chrome.tabs.sendMessage(tabs[0].id, { action: "ping" }, function(response) {
                    if (chrome.runtime.lastError) {
                        console.error("Connection test failed:", chrome.runtime.lastError);
                    } else {
                        console.log("Connection test succeeded:", response);
                    }
                });
            });

            function displayData(data) {
              document.getElementById('contenedor_notificaciones').innerHTML = `<p id="info-container" class="guibis-resultados-info mt-4"></p>`;
                const container = document.getElementById('info-container');
                container.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevos datos

                const table = document.createElement('table');
                table.className = 'guibis-table';
                const thead = document.createElement('thead');
                const tbody = document.createElement('tbody');

                thead.innerHTML = `
                    <tr>
                        <th>Nombre</th>
                        <th>Acción</th>
                    </tr>
                `;

                data.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.nombre}</td>
                        <td>
                            <button id="show-info-${index}" data-username="${item.user_name}" data-email="${item.email}" data-password="${item.password}" data-id="${item.id}" class="guibis-btn-procesar">Procesar</button>
                            <button id="copy-info-${index}" data-username="${item.user_name}" data-password="${item.password}" class="guibis-btn-copiar">Copiar</button>
                        </td>
                    `;
                    tbody.appendChild(row);

                    const processButton = row.querySelector(`#show-info-${index}`);
                    processButton.addEventListener('click', function() {
                        const item = {
                            user_name: processButton.getAttribute('data-username'),
                            email: processButton.getAttribute('data-email'),
                            password: processButton.getAttribute('data-password'),
                            id: processButton.getAttribute('data-id')
                        };

                        chrome.tabs.query({active: true, currentWindow: true}, function(tabs) {
                            chrome.tabs.sendMessage(tabs[0].id, { action: "fillFormFields", item: item }, function(response) {
                                if (chrome.runtime.lastError) {
                                    console.error(chrome.runtime.lastError);
                                }
                                if (response && response.result === "success") {
                                    console.log("Form fields filled successfully.");
                                }
                            });
                        });
                    });

                    const copyButton = row.querySelector(`#copy-info-${index}`);
                    copyButton.addEventListener('click', function() {
                        const username = copyButton.getAttribute('data-username');
                        const password = copyButton.getAttribute('data-password');
                        const textToCopy = `Usuario: ${username}\nContraseña: ${password}`;

                        navigator.clipboard.writeText(textToCopy).then(() => {
                            alert('Contraseña copiada correctamente');
                        }).catch(err => {
                            console.error('Error al copiar al portapapeles:', err);
                        });
                    });
                });

                table.appendChild(thead);
                table.appendChild(tbody);
                container.appendChild(table);
            }

            const searchInput = document.getElementById('search');
            searchInput.addEventListener('input', function() {
              const searchValue = searchInput.value;
              console.log(searchValue);
              if (searchValue.length > 2) {
                  fetch('https://guibis.com/api/user_password_search', {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json'
                      },
                      body: JSON.stringify({
                          authToken: authToken,
                          domain: domain,
                          search: searchValue
                      })
                  })
                  .then(response => response.json())
                  .then(data => {
                      displayData(data);
                      console.log(data);
                  })
                  .catch(error => console.error('Error:', error));

                  function displayData(data) {
                    document.getElementById('contenedor_notificaciones').innerHTML = `<p id="info-container" class="guibis-resultados-info mt-4"></p>`;
                      const container = document.getElementById('info-container');
                      container.innerHTML = '';

                      const table = document.createElement('table');
                      table.className = 'guibis-table';
                      const thead = document.createElement('thead');
                      const tbody = document.createElement('tbody');
                      thead.innerHTML = `
                          <tr>
                              <th>Nombre</th>
                              <th>Acción</th>
                          </tr>
                      `;
                      data.forEach((item, index) => {
                          const row = document.createElement('tr');
                          row.innerHTML = `
                              <td>${item.nombre}</td>
                              <td>
                                  <button id="show-info-${index}" data-username="${item.user_name}" data-email="${item.email}" data-password="${item.password}" data-id="${item.id}" class="guibis-btn-procesar">Procesar</button>
                                  <button id="copy-info-${index}" data-username="${item.user_name}" data-password="${item.password}" class="guibis-btn-copiar">Copiar</button>
                              </td>
                          `;
                          tbody.appendChild(row);
                          const processButton = row.querySelector(`#show-info-${index}`);
                          processButton.addEventListener('click', function() {
                              const item = {
                                  user_name: processButton.getAttribute('data-username'),
                                  email: processButton.getAttribute('data-email'),
                                  password: processButton.getAttribute('data-password'),
                                  id: processButton.getAttribute('data-id')
                              };
                              chrome.tabs.query({active: true, currentWindow: true}, function(tabs) {
                                  chrome.tabs.sendMessage(tabs[0].id, { action: "fillFormFields", item: item }, function(response) {
                                      if (chrome.runtime.lastError) {
                                          console.error(chrome.runtime.lastError);
                                      }
                                      if (response && response.result === "success") {
                                          console.log("Form fields filled successfully.");
                                      }
                                  });
                              });
                          });

                          const copyButton = row.querySelector(`#copy-info-${index}`);
                          copyButton.addEventListener('click', function() {
                              const username = copyButton.getAttribute('data-username');
                              const password = copyButton.getAttribute('data-password');
                              const textToCopy = `Usuario: ${username}\nContraseña: ${password}`;

                              navigator.clipboard.writeText(textToCopy).then(() => {
                                  alert('Contraseña copiada correctamente');
                              }).catch(err => {
                                  console.error('Error al copiar al portapapeles:', err);
                              });
                          });
                      });
                      table.appendChild(thead);
                      table.appendChild(tbody);
                      container.appendChild(table);
                  }
              }
            });
        });
    } else {
        document.getElementById('login-form').addEventListener('submit', function(event) {
            event.preventDefault();

            document.getElementById('contenedor_notificaciones').innerHTML = `<div class="loader"></div>`;
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            fetch('https://guibis.com/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    username: username,
                    password: password
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.authToken) {
                    document.cookie = `username=${username}; path=/;`;
                    document.cookie = `authToken=${data.authToken}; path=/;`;
                    location.reload();
                } else {
                    console.error('Error:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
};
