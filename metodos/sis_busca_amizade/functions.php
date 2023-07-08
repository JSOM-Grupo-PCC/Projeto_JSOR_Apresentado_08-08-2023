<?php

require_once "conn.php";

// Função para obter todos os usuários
function get_users($conn, $search_term = null) {
    $sql = "SELECT * FROM usuario";
    if ($search_term) {
        $sql .= " WHERE username LIKE :search_term";
    }
    $sql .= " ORDER BY username ASC";
    
    $stmt = $conn->prepare($sql);
    if ($search_term) {
        $stmt->bindValue(':search_term', $search_term . '%');
    }
    
    $stmt->execute();
    $get = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total = count($get);
  
    if ($total > 0) {
        
        foreach ($get as $dados) {
            $username = $dados['username'];
            echo "<div style='box-shadow: 0 0 20px rgba(0, 0, 0, 0.3); padding: 10px; margin-bottom: 10px;'>";
            echo "<a style='text-decoration: none !important; color: #83d8ff;' href='/Projeto_Back-end/pages/perfil.php?pagina=perfil&id={$username}'>{$username}</a><br>";
            echo $dados["prenome"] . " " . $dados["sobrenome"] . "<br>";
            echo "</div>";
        }
    } else {
        echo "Nenhum resultado encontrado";
    }
  }
  
  // Função para obter os resultados da pesquisa
  function searchUsers($search_term, $conn) {
    // Preparando a consulta SQL
    $sql = "SELECT * FROM usuario WHERE username LIKE :search_term OR prenome";
  
    // Preparando a declaração PDO
    $stmt = $conn->prepare($sql);
  
    // Vinculando o valor do parâmetro
    $stmt->bindValue(':search_term', $search_term . '%');
  
    // Executando a consulta SQL
    $stmt->execute();
  
    // Obtendo os resultados
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    return $results;
  }
  
// Função para obter o perfil de um usuário
  function get_perfil($conn, $perfil) {
    $sql = $conn->prepare("SELECT * FROM usuario WHERE username = ?");
    $sql->bindParam(1, $perfil);
    $sql->execute();
    $get = $sql->fetchAll(PDO::FETCH_ASSOC);
    $total = count($get);

    if ($total > 0) {
        $dados = $get[0];
        echo "<h3> {$dados['username']}</h3>";
        echo "<small>{$dados['prenome']} {$dados['sobrenome']}</small>";
        verfica_solicitacoes($conn, $_SESSION['id'], $perfil);
    }
}

// Função para verificar se dois usuários são amigos
function verifica_amizade($conn, $username_de, $usaername_para) {
    $sql = $conn->prepare("SELECT * FROM amigo WHERE username_de = ? AND usaername_para = ? AND status = 0");
    $sql->bindParam(1, $username_de);
    $sql->bindParam(2, $usaername_para);
    $sql->execute();

    return count($sql->fetchAll(PDO::FETCH_ASSOC));
}

// Função para enviar solicitação de amizade
function send_solicitation($conn, $usaername_para) {
    if (verifica_amizade($conn, $_SESSION['id'], $usaername_para) <= 0) {
        $sql = $conn->prepare("INSERT INTO amigo (username_de, usaername_para) VALUES (?, ?)");
        $sql->bindParam(1, $_SESSION['id']);
        $sql->bindParam(2, $usaername_para);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            redireciona("/Projeto_Back-end/pages/perfil.php?pagina=perfil&id={$usaername_para}");
        } else {
            return false;
        }
    } else {
        redireciona("/Projeto_Back-end/pages/perfil.php?pagina=perfil&id={$usaername_para}");
    }
}

// Função para verificar as solicitações de amizade
function verfica_solicitacoes($conn, $username_de, $usaername_para) {
    $sql = $conn->prepare("SELECT * FROM amigo WHERE (username_de = ? AND usaername_para = ?) OR (usaername_para = ? AND username_de = ?)");
    $sql->bindParam(1, $username_de);
    $sql->bindParam(2, $usaername_para);
    $sql->bindParam(3, $username_de);
    $sql->bindParam(4, $usaername_para);
    $sql->execute();
    $get = $sql->fetchAll(PDO::FETCH_ASSOC);
    $total = count($get);

    if ($total > 0) {
        $dados = $get[0];

        if ($dados['status'] == 1) {
            echo "<a style='text-decoration: none !important; color: #ff0000;' href='/Projeto_Back-end/pages/desfazer-amizade.php?pagina=desfazer-amizade&id={$dados['id']}'>Desfazer Amizade</a>";
            $_SESSION['usaername_para'] = $usaername_para;
        }

        if ($dados['usaername_para'] == $usaername_para && $dados['username_de'] == $username_de && $dados['status'] == 0) {
            echo "<a style='text-decoration: none !important; color: #ff0000;' href='/Projeto_Back-end/pages/desfazer-amizade.php?pagina=desfazer-amizade&id={$dados['id']}'>Cancelar Solicitação</a>";
            $_SESSION['usaername_para'] = $usaername_para;
        }

        if ($dados['username_de'] == $usaername_para && $dados['usaername_para'] == $username_de && $dados['status'] == 0) {

            echo "<a style='text-decoration: none !important; color: #83d858;' href='/Projeto_Back-end/pages/aceitar-amizade.php?pagina=aceitar-amizade&id={$dados['username_de']}'>Aceitar Solicitação</a>";

            echo "<a style='text-decoration: none !important; color: #ff0000;' href='/Projeto_Back-end/pages/recusar-solicitacao.php?pagina=desfazer-amizade&id={$dados['id']}'>Recusar Solicitação</a>";

            
        }
    } else if ($total <= 0 && $usaername_para != $username_de) {
        echo "<a style='text-decoration: none !important; color: #83d858;' href='/Projeto_Back-end/pages/solicitar-amizade.php?pagina=solicitar-amizade&id={$usaername_para}'>Adicionar Amigo</a>";
        $_SESSION['usaername_para'] = $usaername_para;
    }
}

// Função para excluir uma solicitação de amizade
function deleta_solicitacao($conn, $id) {
    $sql = $conn->prepare("DELETE FROM amigo WHERE id = ?");
    $sql->bindParam(1, $id);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        redireciona("/Projeto_Back-end/pages/desfazer-amizade.php?pagina=desfazer-amizade");
    } else {
        return false;
    }
}

// Função para recusar uma solicitação de amizade
function recusar_solicitacao($conn, $id) {
    $sql = $conn->prepare("DELETE FROM amigo WHERE id = ?");
    $sql->bindParam(1, $id);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        redireciona("/Projeto_Back-end/pages/solicitacoes.php?pagina=solicitacoes");
    } else {
        return false;
    }
}

// Função para aceitar uma solicitação de amizade
function aceita_solicitacao($conn, $username_de) {
    $sql = $conn->prepare("SELECT * FROM amigo WHERE username_de = ? AND usaername_para = ? AND status = 0");
    $sql->bindParam(1, $username_de);
    $sql->bindParam(2, $_SESSION['id']);
    $sql->execute();
    $get = $sql->fetchAll(PDO::FETCH_ASSOC);
    $total = count($get);

    if ($total > 0) {
        $dados = $get[0];

        if ($dados['usaername_para'] == $_SESSION['id']) {
            if (atualiza_solicitacao($conn, $username_de, $_SESSION['id']) > 0) {
                redireciona("/Projeto_Back-end/pages/perfil.php?pagina=perfil&id={$username_de}");
            } else {
                echo "erro ao atualizar;";
            }
        } else {
            return false;
        }
    }
}

// Função para atualizar o status de uma solicitação de amizade
function atualiza_solicitacao($conn, $username_de, $usaername_para) {
    $sql = $conn->prepare("UPDATE amigo SET status = 1 WHERE username_de = ? AND usaername_para = ?");
    $sql->bindParam(1, $username_de);
    $sql->bindParam(2, $usaername_para);
    $sql->execute();

    return $sql->rowCount();
}

// Função para redirecionar para uma página
function redireciona($dir) {
    echo "<meta http-equiv='Refresh' content='0; url={$dir}'/>";
}

// Função para exibir as solicitações de amizade
function solicitacoes($conn) {
    if (isset($_SESSION['id'])) {
        $sql = $conn->prepare("SELECT * FROM amigo WHERE usaername_para = ? AND status = 0");
        $sql->bindParam(1, $_SESSION['id']);
        $sql->execute();
        $get = $sql->fetchAll(PDO::FETCH_ASSOC);
        $total = count($get);

        if ($total > 0) {
            foreach ($get as $dados) {
                
                echo "
                <ul>
                    <br>
                        <li style='list-style:none;'>
                        <a style='color: #fff; font-weight:700; ' href='/Projeto_Back-end/pages/perfil.php?pagina=perfil&id={$dados['username_de']}'>
                        {$dados['username_de']} 
                        <br>

                        <a style='color: #83d858;' href='/Projeto_Back-end/pages/aceitar-amizade.php?pagina=aceitar-amizade&id={$dados['username_de']}'>Aceitar Solicitação</a> 

                        <a style='color: #ff0000 ;' href='/Projeto_Back-end/pages/recusar-solicitacao.php?pagina=recusar-solicitacao&id={$dados['id']}'>Recusar Solicitação</a>
                        </a>
                        </li>                    
                    <hr>
                </ul>";
                $_SESSION['usaername_de'] = $dados['username_de'];     
            }
        }
        
    } else {
        exit();
    }
}

// Função para retornar o total de solicitações de amizade
function return_total_solicitation($conn) {
    $sql = $conn->prepare("SELECT * FROM amigo WHERE usaername_para = ? AND status = 0");
    $sql->bindParam(1, $_SESSION['id']);
    $sql->execute();
    $get = $sql->fetchAll(PDO::FETCH_ASSOC);
    $total = count($get);

    if ($total > 0) {
        return ": ".$total;
    }
}
