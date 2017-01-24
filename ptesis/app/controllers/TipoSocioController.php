<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class TipoSocioController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for tipo_socio
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'TipoSocio', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "tipo_socio_id";

        $tipo_socio = TipoSocio::find($parameters);
        if (count($tipo_socio) == 0) {
            $this->flash->notice("The search did not find any tipo_socio");

            $this->dispatcher->forward([
                "controller" => "tipo_socio",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $tipo_socio,
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
     * Edits a tipo_socio
     *
     * @param string $tipo_socio_id
     */
    public function editAction($tipo_socio_id)
    {
        if (!$this->request->isPost()) {

            $tipo_socio = TipoSocio::findFirstBytipo_socio_id($tipo_socio_id);
            if (!$tipo_socio) {
                $this->flash->error("tipo_socio was not found");

                $this->dispatcher->forward([
                    'controller' => "tipo_socio",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->tipo_socio_id = $tipo_socio->tipo_socio_id;

            $this->tag->setDefault("tipo_socio_id", $tipo_socio->tipo_socio_id);
            $this->tag->setDefault("tipo_socio", $tipo_socio->tipo_socio);
            $this->tag->setDefault("codigo", $tipo_socio->codigo);
            $this->tag->setDefault("descripcion", $tipo_socio->descripcion);
            $this->tag->setDefault("activo", $tipo_socio->activo);
            
        }
    }

    /**
     * Creates a new tipo_socio
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tipo_socio",
                'action' => 'index'
            ]);

            return;
        }

        $tipo_socio = new TipoSocio();
        $tipo_socio->tipo_socio_id = $this->request->getPost("tipo_socio_id");
        $tipo_socio->tipo_socio = $this->request->getPost("tipo_socio");
        $tipo_socio->codigo = $this->request->getPost("codigo");
        $tipo_socio->descripcion = $this->request->getPost("descripcion");
        $tipo_socio->activo = $this->request->getPost("activo");
        

        if (!$tipo_socio->save()) {
            foreach ($tipo_socio->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tipo_socio",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("tipo_socio was created successfully");

        $this->dispatcher->forward([
            'controller' => "tipo_socio",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a tipo_socio edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tipo_socio",
                'action' => 'index'
            ]);

            return;
        }

        $tipo_socio_id = $this->request->getPost("tipo_socio_id");
        $tipo_socio = TipoSocio::findFirstBytipo_socio_id($tipo_socio_id);

        if (!$tipo_socio) {
            $this->flash->error("tipo_socio does not exist " . $tipo_socio_id);

            $this->dispatcher->forward([
                'controller' => "tipo_socio",
                'action' => 'index'
            ]);

            return;
        }

        $tipo_socio->tipo_socio_id = $this->request->getPost("tipo_socio_id");
        $tipo_socio->tipo_socio = $this->request->getPost("tipo_socio");
        $tipo_socio->codigo = $this->request->getPost("codigo");
        $tipo_socio->descripcion = $this->request->getPost("descripcion");
        $tipo_socio->activo = $this->request->getPost("activo");
        

        if (!$tipo_socio->save()) {

            foreach ($tipo_socio->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tipo_socio",
                'action' => 'edit',
                'params' => [$tipo_socio->tipo_socio_id]
            ]);

            return;
        }

        $this->flash->success("tipo_socio was updated successfully");

        $this->dispatcher->forward([
            'controller' => "tipo_socio",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a tipo_socio
     *
     * @param string $tipo_socio_id
     */
    public function deleteAction($tipo_socio_id)
    {
        $tipo_socio = TipoSocio::findFirstBytipo_socio_id($tipo_socio_id);
        if (!$tipo_socio) {
            $this->flash->error("tipo_socio was not found");

            $this->dispatcher->forward([
                'controller' => "tipo_socio",
                'action' => 'index'
            ]);

            return;
        }

        if (!$tipo_socio->delete()) {

            foreach ($tipo_socio->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tipo_socio",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("tipo_socio was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "tipo_socio",
            'action' => "index"
        ]);
    }

}
