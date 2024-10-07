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
                // Crear la tabla y el encabezado
                const table = document.createElement('table');
                table.className = 'guibis-table';
                const thead = document.createElement('thead');
                const tbody = document.createElement('tbody');
                // Crear encabezado de la tabla
                thead.innerHTML = `
                    <tr>
                        <th>Nombre</th>
                        <th>Acción</th>
                    </tr>
                `;
                // Agregar datos a la tabla
                data.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.nombre}</td>
                        <td><button id="show-info-${index}" data-username="${item.user_name}" data-email="${item.email}" data-password="${item.password}" data-id="${item.id}" class="guibis-btn-procesar boton_general_extension_guibis">Procesar</button>
                         <button id="copy-info-${index}" data-username="${item.user_name}" data-password="${item.password}" class="guibis-btn-copiar boton_general_extension_guibis">Copiar</button>

                        </td>
                    `;
                    tbody.appendChild(row);
                    const button = row.querySelector(`#show-info-${index}`);
                    button.addEventListener('click', function() {
                        const item = {
                            user_name: button.getAttribute('data-username'),
                            email: button.getAttribute('data-email'),
                            password: button.getAttribute('data-password'),
                            id: button.getAttribute('data-id')
                        };
                        // Enviar mensaje al script de contenido activo
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
            //COLOCAR AQUI EL CODIGO DEL BUSCADOR
            const searchInput = document.getElementById('search');
            searchInput.addEventListener('input', function() {
              const searchValue = searchInput.value;
              console.log(searchValue);
              if (searchValue.length > 2) { // Realizar la búsqueda después de que el usuario escriba al menos 3 caracteres
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
                      container.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevos datos

                      // Crear la tabla y el encabezado
                      const table = document.createElement('table');
                      table.className = 'guibis-table';
                      const thead = document.createElement('thead');
                      const tbody = document.createElement('tbody');
                      // Crear encabezado de la tabla
                      thead.innerHTML = `
                          <tr>
                              <th>Nombre</th>
                              <th>Acción</th>
                          </tr>
                      `;
                      // Agregar datos a la tabla
                      data.forEach((item, index) => {
                          const row = document.createElement('tr');
                          row.innerHTML = `
                              <td>${item.nombre}</td>
                              <td><button id="show-info-${index}" data-username="${item.user_name}" data-email="${item.email}" data-password="${item.password}" data-id="${item.id}" class="guibis-btn-procesar boton_general_extension_guibis">Procesar</button>
                              <button id="copy-info-${index}" data-username="${item.user_name}" data-password="${item.password}" class="guibis-btn-copiar boton_general_extension_guibis">Copiar</button>

                              </td>
                          `;
                          tbody.appendChild(row);
                          const button = row.querySelector(`#show-info-${index}`);
                          button.addEventListener('click', function() {
                              const item = {
                                  user_name: button.getAttribute('data-username'),
                                  email: button.getAttribute('data-email'),
                                  password: button.getAttribute('data-password'),
                                  id: button.getAttribute('data-id')
                              };
                              // Enviar mensaje al script de contenido activo
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
                      // Agregar encabezado y cuerpo a la tabla
                      table.appendChild(thead);
                      table.appendChild(tbody);

                      // Agregar la tabla al contenedor
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
            const rememberMe = document.getElementById('remember-me').checked;

            fetch('https://guibis.com/api/user', {
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
                if (data.respuesta === 'success') {

                    console.log(data);
                    document.cookie = `authToken=${data.codigo}; path=/; ${rememberMe ? 'max-age=31536000;' : ''}`;
                    document.cookie = `username=${username}; path=/; ${rememberMe ? 'max-age=31536000;' : ''}`;
                    document.getElementById('login-form').style.display = 'none';
                    document.getElementById('session-info').innerHTML = `Sesión iniciada por ${username} <button id="logout">Cerrar sesión</button>`;
                    document.getElementById('logout').addEventListener('click', function() {
                        document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                        document.cookie = "authToken=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                        location.reload();
                    });
                  document.getElementById('contenedor_notificaciones').innerHTML = ``;

                  chrome.tabs.query({ active: true, currentWindow: true }, (tabs) => {
                      const domain = new URL(tabs[0].url).hostname;
                      document.getElementById('informacion_dominio_analizar').innerHTML = `${domain}`;
                      fetch('https://guibis.com/api/user_password', {
                          method: 'POST',
                          headers: {
                              'Content-Type': 'application/json'
                          },
                          body: JSON.stringify({
                              authToken: data.codigo,
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
                          // Crear la tabla y el encabezado
                          const table = document.createElement('table');
                          table.className = 'guibis-table';
                          const thead = document.createElement('thead');
                          const tbody = document.createElement('tbody');
                          // Crear encabezado de la tabla
                          thead.innerHTML = `
                              <tr>
                                  <th>Nombre</th>
                                  <th>Acción</th>
                              </tr>
                          `;
                          // Agregar datos a la tabla
                          data.forEach((item, index) => {
                              const row = document.createElement('tr');
                              row.innerHTML = `
                                  <td>${item.nombre}</td>
                                  <td><button id="show-info-${index}" data-username="${item.user_name}" data-email="${item.email}" data-password="${item.password}" data-id="${item.id}" class="guibis-btn-procesar boton_general_extension_guibis">Procesar</button>
                                  <button id="copy-info-${index}" data-username="${item.user_name}" data-password="${item.password}" class="guibis-btn-copiar boton_general_extension_guibis">Copiar</button>
                                  </td>`;
                              tbody.appendChild(row);
                              const button = row.querySelector(`#show-info-${index}`);
                              button.addEventListener('click', function() {
                                  const item = {
                                      user_name: button.getAttribute('data-username'),
                                      email: button.getAttribute('data-email'),
                                      password: button.getAttribute('data-password'),
                                      id: button.getAttribute('data-id')
                                  };
                                  // Enviar mensaje al script de contenido activo
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
                      //COLOCAR AQUI EL CODIGO DEL BUSCADOR
                      const searchInput = document.getElementById('search');
                      searchInput.addEventListener('input', function() {
                        const searchValue = searchInput.value;
                        console.log(searchValue);
                        if (searchValue.length > 2) { // Realizar la búsqueda después de que el usuario escriba al menos 3 caracteres
                            fetch('https://guibis.com/api/user_password_search', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    authToken: data.codigo,
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
                                container.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevos datos

                                // Crear la tabla y el encabezado
                                const table = document.createElement('table');
                                table.className = 'guibis-table';
                                const thead = document.createElement('thead');
                                const tbody = document.createElement('tbody');
                                // Crear encabezado de la tabla
                                thead.innerHTML = `
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Acción</th>
                                    </tr>
                                `;
                                // Agregar datos a la tabla
                                data.forEach((item, index) => {
                                    const row = document.createElement('tr');
                                    row.innerHTML = `
                                        <td>${item.nombre}</td>
                                        <td><button id="show-info-${index}" data-username="${item.user_name}" data-email="${item.email}" data-password="${item.password}" data-id="${item.id}" class="guibis-btn-procesar boton_general_extension_guibis">Procesar</button>
                                        <button id="copy-info-${index}" data-username="${item.user_name}" data-password="${item.password}" class="guibis-btn-copiar boton_general_extension_guibis">Copiar</button>

                                        </td>`;
                                    tbody.appendChild(row);
                                    const button = row.querySelector(`#show-info-${index}`);
                                    button.addEventListener('click', function() {
                                        const item = {
                                            user_name: button.getAttribute('data-username'),
                                            email: button.getAttribute('data-email'),
                                            password: button.getAttribute('data-password'),
                                            id: button.getAttribute('data-id')
                                        };
                                        // Enviar mensaje al script de contenido activo
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
                                // Agregar encabezado y cuerpo a la tabla
                                table.appendChild(thead);
                                table.appendChild(tbody);

                                // Agregar la tabla al contenedor
                                container.appendChild(table);
                            }
                        }
                      });
                  });

                }
                if (data.respuesta === 'error_credenciales') {
                  document.getElementById('contenedor_notificaciones').innerHTML = `<div class="guibis-alert guibis-alert-danger"><strong>Error en Credenciales!</strong>Intenta Nuevamente.</div>`;
                }

                if (data.respuesta === 'usuario no encontrado') {
                  document.getElementById('contenedor_notificaciones').innerHTML = `<div class="guibis-alert guibis-alert-danger"><strong>No existe usuario!</strong>Crea una cuenta.</div>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });

        });
    }
};
