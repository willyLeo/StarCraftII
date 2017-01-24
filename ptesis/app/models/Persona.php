<?php

class Persona extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(type="string", length=32, nullable=false)
     */
    public $persona_id;

    /**
     *
     * @var string
     * @Column(type="string", length=45, nullable=false)
     */
    public $nombres;

    /**
     *
     * @var string
     * @Column(type="string", length=45, nullable=false)
     */
    public $apellidos;

    /**
     *
     * @var string
     * @Column(type="string", length=8, nullable=false)
     */
    public $dni;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $direccion;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $fecha_nacimiento;

    /**
     *
     * @var string
     * @Column(type="string", length=15, nullable=true)
     */
    public $telefono_fijo;

    /**
     *
     * @var string
     * @Column(type="string", length=15, nullable=true)
     */
    public $telefono_movil;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=true)
     */
    public $estado_civil;

    /**
     *
     * @var string
     * @Column(type="string", length=1, nullable=false)
     */
    public $activo;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $fecha_creacion;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    public $usuario_creacion;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('persona_id', 'Empleado', 'persona_id', ['alias' => 'Empleado']);
        $this->hasMany('persona_id', 'Socio', 'persona_id', ['alias' => 'Socio']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'persona';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Persona[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Persona
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
