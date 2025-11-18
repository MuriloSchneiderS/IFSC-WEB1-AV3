document.addEventListener('DOMContentLoaded', () => {
    const apiUrl = '../backend/api.php';
    const postForm = document.getElementById('postForm');
    const listaPosts = document.getElementById('listaPosts');

    fetchPosts();

    postForm.addEventListener('submit', handleFormSubmit);

    listaPosts.addEventListener('click', (event) => {
        handleFavoriteClick(event);
        handleEditClick(event);
        handleDeleteClick(event);
    });

    // Função para carregar a lista de posts
    async function fetchPosts() {
        listaPosts.innerHTML = '<p>Nenhum post encontrado.</p>';//Mensagem padrão

        try {
            const response = await fetch(`${apiUrl}?action=readAll`);
            if (!response.ok)
                throw new Error('Erro ao buscar posts: ' + response.statusText);
            //Armazena o resultado em uma lista de posts em formato JSON
            const posts = await response.json();

            posts.forEach(post => {
                const div = document.createElement('div');
                div.innerHTML = `
                <div class="post p-3 rounded shadow-sm bg-dark">
                    <div class="post-header d-flex justify-content-between align-items-center mb-2">
                        <small class="text-white-50">${post.data_criacao}</small>
                        <div>
                            <div id="post_lista">
                                <button name="favoritar_post" data-id="${post.id}" type="button" class="btn btn-sm btn-warning me-2">
                                    <!-- Ícone de estrela preenchida se for favorito(bi-star-fill / bi-star) -->
                                    <i class="bi bi-star${post.status===1?'-fill':''}"></i>
                                </button>
                                <button name="editar_post" data-id="${post.id}" type="button" class="btn btn-sm btn-primary me-2">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button name="excluir_post" data-id="${post.id}" type="button" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="post-body">
                        <p name="mensagem_post" class="mb-0">${post.mensagem}</p>
                    </div>
                </div>
                `;
                listaPosts.appendChild(div);
            });
        } catch (error) {
            console.error('Erro no fetchPosts:', error);
        }
    }

    async function handleFormSubmit(event) {
        event.preventDefault();

        const id = postForm.dataset.id; // Verifica se há um ID armazenado para edição
        const mensagem = postForm.mensagem.value;
        const status = postForm.status ? (postForm.status.checked ? 1 : 0) : 0;
        const data_criacao = formatDate(new Date());

        const postData = { mensagem, status, data_criacao };
        let action = 'create';

        if (id) {
            postData.id = id;
            action = 'update';
        }

        try {
            const response = await fetch(`${apiUrl}?action=${action}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(postData),
            });

            if (response.status != 204){//204 No Content para update
                const result = await response.json();
                if (!response.ok) {
                    alert(result.message || 'Erro ao salvar post.');
                    return;
                }
            }

            resetForm();
            fetchPosts();

        } catch (error) {
            console.error('Erro ao salvar post:', error);
            alert('Erro ao salvar post.');
        }
    }

    //editar_post
    async function handleEditClick(event) {
        if (event.target.name!='editar_post')
            return;

        const id = event.target.dataset.id;
        
        try {
            const response = await fetch(`${apiUrl}?action=readOne&id=${id}`);
            const post = await response.json();

            postForm.mensagem.value = post.mensagem;
            postForm.dataset.id = post.id; // Armazena o ID do post no formulário
            postForm.dataset.action = 'update'; // Define a ação como 'update' para edição
        } catch (error) {
            console.error('Erro ao buscar post para edição:', error);
        }
    }

    //excluir_post
    async function handleDeleteClick(event) {
        if (event.target.name!='excluir_post')
            return;

        const id = event.target.dataset.id;
        
        if (!confirm('Tem certeza que deseja deletar este post?'))
            return;
        //Chama a API para deletar o post depois do usuario confirmar a exclusao
        try {
            const response = await fetch(`${apiUrl}?action=delete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: id }),
            });
            if (response.status != 204){//204 No Content para update
                const result = await response.json();
                if (!response.ok) {
                    alert(result.message || 'Erro ao salvar post.');
                    return;
                }
            }
            
            fetchPosts();
        } catch (error) {
            console.error('Erro ao deletar post:', error);
            alert('Erro ao deletar post.');
        }
    }

    //favoritar_post
    async function handleFavoriteClick(event) {
        if (event.target.name!='favoritar_post')
            return;
        const id = event.target.dataset.id;

        try {
            const response = await fetch(`${apiUrl}?action=favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: id }),
            });
            if (response.status != 204){//204 No Content para update
                const result = await response.json();
                if (!response.ok) {
                    alert(result.message || 'Erro ao favoritar post.');
                    return;
                }
            }
            
            fetchPosts();
        } catch (error) {
            console.error('Erro ao favoritar post:', error);
            alert('Erro ao favoritar post.');
        }
    }

    //reset form
    function resetForm() {
        postForm.reset();
        delete postForm.dataset.id;
        delete postForm.dataset.action;
    }
    
    //Função para formatar a data
    function formatDate(date) {
        // Format as 'YYYY-MM-DD HH:MM:SS'
        const pad = n => n < 10 ? '0' + n : n;
        return date.getFullYear() + '-' +
            pad(date.getMonth() + 1) + '-' +
            pad(date.getDate()) + ' ' +
            pad(date.getHours()) + ':' +
            pad(date.getMinutes()) + ':' +
            pad(date.getSeconds());
    }
});