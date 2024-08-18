<?php

namespace App\Controllers; // Define o namespace para a classe Crud dentro do diretório Controllers

use App\Models\CrudModel;
use App\Models\TeamModel; // Importa a classe CrudModel para ser usada neste controlador

class Crud extends BaseController // Define a classe Crud que estende a classe BaseController
{
    function index()
    {
        // Cria uma instância do modelo CrudModel
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }
        $crudModel = new CrudModel();

        // Obtém os dados dos usuários ordenados por ID de forma decrescente e paginados

        $data['user_data'] = $crudModel->getData();

        $teamModel = new TeamModel();
        $data['team'] = $teamModel->orderBy('id', 'DESC')->paginate(10);
        // Obtém os links de paginação

        $data['pagination_link'] = $crudModel->pager;

        // Retorna a visualização 'crud/index' com os dados obtidos

        return view('crud/index', $data);
    }

    function view()
    {
        // Cria uma instância do modelo CrudModel

        $crudModel = new CrudModel();

        // Obtém os dados dos usuários ordenados por ID de forma decrescente e paginados

        $data['user_data'] = $crudModel->getData();

        // Obtém os links de paginação

        $data['pagination_link'] = $crudModel->pager;

        // Retorna a visualização 'crud/index' com os dados obtidos

        return view('crud/view', $data);
    }


    public function createSave()
    {
        $model = new CrudModel(); // Cria uma nova instância do modelo CrudModel para interagir com o banco de dados

        // Validate input
        $validation = \Config\Services::validation(); // Obtém o serviço de validação
        $validation->setRules([ // Define as regras de validação para os campos
            'name' => 'required',
            'equipaantiga' => 'required',
            'equipanova' => 'required',
            'modality' => 'required'
        ]);

        if ($validation->withRequest($this->request)->run()) { // Verifica se os dados passam na validação
            // Se os dados passarem na validação, cria um array com os dados recebidos do formulário
            $data = [
                'name' => $this->request->getPost('name'),
                'equipaantiga' => $this->request->getPost('equipaantiga'),
                'equipanova' => $this->request->getPost('equipanova'),
                'modality' => $this->request->getpost('modality')
            ];
            // Salva os dados no banco de dados usando o método insert() do modelo CrudModel
            $model->insert($data);

            // Redireciona de volta à página inicial com uma mensagem de sucesso
            return redirect()->to('/')->with('success', 'Adicionado com sucesso.');
        } else {
            // Se os dados não passarem na validação, exibe os erros de validação
            print_r($validation->getErrors()); // Imprime os erros de validação no formato de array
            exit; // Encerra o script após a impressão dos erros (pode ser removido em ambiente de produção)
            return redirect()->back()->withInput()->with('errors', $validation->getErrors()); // Redireciona de volta à página anterior com os erros de validação e os dados do formulário
        }
    }


    public function update($id)
    {
        $model = new CrudModel(); // Cria uma nova instância do modelo CrudModel para interagir com o banco de dados

        // Validation
        $rules = [ // Define as regras de validação para os campos
            'name' => 'required',
            'equipaantiga' => 'required',
            'equipanova' => 'required',
            'modality' => 'required'
        ];
        if (!$this->validate($rules)) { // Verifica se os dados passam na validação
            // Se os dados não passarem na validação, redireciona de volta à página anterior com os erros de validação e os dados do formulário
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data
        $data = [ // Cria um array com os dados recebidos do formulário
            'name' => $this->request->getPost('name'),
            'equipaantiga' => $this->request->getPost('equipaantiga'),
            'equipanova' => $this->request->getPost('equipanova'),
            'modality' => $this->request->getpost('modality')
        ];

        // Atualiza os dados no banco de dados usando o método update() do modelo CrudModel
        $model->update($id, $data);

        // Redireciona de volta à página inicial com uma mensagem de sucesso
        return redirect()->to('/')->with('success', 'Atualizado com sucesso.');
    }


    public function delete($id)
    {
        $model = new CrudModel(); // Cria uma nova instância do modelo CrudModel para interagir com o banco de dados

        $model->delete($id); // Chama o método delete() do modelo para excluir o registro com o ID fornecido

        // Redireciona de volta à página inicial com uma mensagem de sucesso
        return redirect()->to('/')->with('success', 'Apagado com sucesso.');
    }
}
