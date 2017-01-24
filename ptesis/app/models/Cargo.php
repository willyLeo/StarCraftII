<?php

class Cargo extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $cargo_id;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    public $cargo;

    /**
     *
     * @var string
     * @Column(type="string", length=25, nullable=false)
     */
    public $codigo;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $descripcion;

    /**
     *
     * @var string
     * @Column(type="string", length=1, nullable=false)
     */
    public $activo;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('cargo_id', 'Empleado', 'cargo_id', ['alias' => 'Empleado']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'cargo';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cargo[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cargo
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
