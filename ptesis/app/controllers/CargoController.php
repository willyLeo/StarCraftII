<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class CargoController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for cargo
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Cargo', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "cargo_id";

        $cargo = Cargo::find($parameters);
        if (count($cargo) == 0) {
            $this->flash->notice("The search did not find any cargo");

            $this->dispatcher->forward([
                "controller" => "cargo",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $cargo,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a cargo
     *
     * @param string $cargo_id
     */
    public function editAction($cargo_id)
    {
        if (!$this->request->isPost()) {

            $cargo = Cargo::findFirstBycargo_id($cargo_id);
            if (!$cargo) {
                $this->flash->error("cargo was not found");

                $this->dispatcher->forward([
                    'controller' => "cargo",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->cargo_id = $cargo->cargo_id;

            $this->tag->setDefault("cargo_id", $cargo->cargo_id);
            $this->tag->setDefault("cargo", $cargo->cargo);
            $this->tag->setDefault("codigo", $cargo->codigo);
            $this->tag->setDefault("descripcion", $cargo->descripcion);
            $this->tag->setDefault("activo", $cargo->activo);
            
        }
    }

    /**
     * Creates a new cargo
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "cargo",
                'action' => 'index'
            ]);

            return;
        }

        $cargo = new Cargo();
        $cargo->cargo = $this->request->getPost("cargo");
        $cargo->codigo = $this->request->getPost("codigo");
        $cargo->descripcion = $this->request->getPost("descripcion");
        $cargo->activo = $this->request->getPost("activo");
        

        if (!$cargo->save()) {
            foreach ($cargo->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "cargo",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("cargo was created successfully");

        $this->dispatcher->forward([
            'controller' => "cargo",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a cargo edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "cargo",
                'action' => 'index'
            ]);

            return;
        }

        $cargo_id = $this->request->getPost("cargo_id");
        $cargo = Cargo::findFirstBycargo_id($cargo_id);

        if (!$cargo) {
            $this->flash->error("cargo does not exist " . $cargo_id);

            $this->dispatcher->forward([
                'controller' => "cargo",
                'action' => 'index'
            ]);

            return;
        }

        $cargo->cargo = $this->request->getPost("cargo");
        $cargo->codigo = $this->request->getPost("codigo");
        $cargo->descripcion = $this->request->getPost("descripcion");
        $cargo->activo = $this->request->getPost("activo");
        

        if (!$cargo->save()) {

            foreach ($cargo->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "cargo",
                'action' => 'edit',
                'params' => [$cargo->cargo_id]
            ]);

            return;
        }

        $this->flash->success("cargo was updated successfully");

        $this->dispatcher->forward([
            'controller' => "cargo",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a cargo
     *
     * @param string $cargo_id
     */
    public function deleteAction($cargo_id)
    {
        $cargo = Cargo::findFirstBycargo_id($cargo_id);
        if (!$cargo) {
            $this->flash->error("cargo was not found");

            $this->dispatcher->forward([
                'controller' => "cargo",
                'action' => 'index'
            ]);

            return;
        }

        if (!$cargo->delete()) {

            foreach ($cargo->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "cargo",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("cargo was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "cargo",
            'action' => "index"
        ]);
    }

}
