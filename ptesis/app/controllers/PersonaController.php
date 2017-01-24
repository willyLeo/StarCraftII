<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class PersonaController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for persona
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Persona', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "persona_id";

        $persona = Persona::find($parameters);
        if (count($persona) == 0) {
            $this->flash->notice("The search did not find any persona");

            $this->dispatcher->forward([
                "controller" => "persona",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $persona,
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
     * Edits a persona
     *
     * @param string $persona_id
     */
    public function editAction($persona_id)
    {
        if (!$this->request->isPost()) {

            $persona = Persona::findFirstBypersona_id($persona_id);
            if (!$persona) {
                $this->flash->error("persona was not found");

                $this->dispatcher->forward([
                    'controller' => "persona",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->persona_id = $persona->persona_id;

            $this->tag->setDefault("persona_id", $persona->persona_id);
            $this->tag->setDefault("nombres", $persona->nombres);
            $this->tag->setDefault("apellidos", $persona->apellidos);
            $this->tag->setDefault("dni", $persona->dni);
            $this->tag->setDefault("direccion", $persona->direccion);
            $this->tag->setDefault("fecha_nacimiento", $persona->fecha_nacimiento);
            $this->tag->setDefault("telefono_fijo", $persona->telefono_fijo);
            $this->tag->setDefault("telefono_movil", $persona->telefono_movil);
            $this->tag->setDefault("estado_civil", $persona->estado_civil);
            $this->tag->setDefault("activo", $persona->activo);
            $this->tag->setDefault("fecha_creacion", $persona->fecha_creacion);
            $this->tag->setDefault("usuario_creacion", $persona->usuario_creacion);
            
        }
    }

    /**
     * Creates a new persona
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "persona",
                'action' => 'index'
            ]);

            return;
        }

        $persona = new Persona();
        $persona->persona_id = $this->request->getPost("persona_id");
        $persona->nombres = $this->request->getPost("nombres");
        $persona->apellidos = $this->request->getPost("apellidos");
        $persona->dni = $this->request->getPost("dni");
        $persona->direccion = $this->request->getPost("direccion");
        $persona->fecha_nacimiento = $this->request->getPost("fecha_nacimiento");
        $persona->telefono_fijo = $this->request->getPost("telefono_fijo");
        $persona->telefono_movil = $this->request->getPost("telefono_movil");
        $persona->estado_civil = $this->request->getPost("estado_civil");
        $persona->activo = $this->request->getPost("activo");
        $persona->fecha_creacion = $this->request->getPost("fecha_creacion");
        $persona->usuario_creacion = $this->request->getPost("usuario_creacion");
        

        if (!$persona->save()) {
            foreach ($persona->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "persona",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("persona was created successfully");

        $this->dispatcher->forward([
            'controller' => "persona",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a persona edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "persona",
                'action' => 'index'
            ]);

            return;
        }

        $persona_id = $this->request->getPost("persona_id");
        $persona = Persona::findFirstBypersona_id($persona_id);

        if (!$persona) {
            $this->flash->error("persona does not exist " . $persona_id);

            $this->dispatcher->forward([
                'controller' => "persona",
                'action' => 'index'
            ]);

            return;
        }

        $persona->persona_id = $this->request->getPost("persona_id");
        $persona->nombres = $this->request->getPost("nombres");
        $persona->apellidos = $this->request->getPost("apellidos");
        $persona->dni = $this->request->getPost("dni");
        $persona->direccion = $this->request->getPost("direccion");
        $persona->fecha_nacimiento = $this->request->getPost("fecha_nacimiento");
        $persona->telefono_fijo = $this->request->getPost("telefono_fijo");
        $persona->telefono_movil = $this->request->getPost("telefono_movil");
        $persona->estado_civil = $this->request->getPost("estado_civil");
        $persona->activo = $this->request->getPost("activo");
        $persona->fecha_creacion = $this->request->getPost("fecha_creacion");
        $persona->usuario_creacion = $this->request->getPost("usuario_creacion");
        

        if (!$persona->save()) {

            foreach ($persona->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "persona",
                'action' => 'edit',
                'params' => [$persona->persona_id]
            ]);

            return;
        }

        $this->flash->success("persona was updated successfully");

        $this->dispatcher->forward([
            'controller' => "persona",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a persona
     *
     * @param string $persona_id
     */
    public function deleteAction($persona_id)
    {
        $persona = Persona::findFirstBypersona_id($persona_id);
        if (!$persona) {
            $this->flash->error("persona was not found");

            $this->dispatcher->forward([
                'controller' => "persona",
                'action' => 'index'
            ]);

            return;
        }

        if (!$persona->delete()) {

            foreach ($persona->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "persona",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("persona was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "persona",
            'action' => "index"
        ]);
    }

}
