<?php

class Unidad extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(type="string", length=32, nullable=false)
     */
    public $unidad_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $numero;

    /**
     *
     * @var string
     * @Column(type="string", length=7, nullable=false)
     */
    public $placa;

    /**
     *
     * @var string
     * @Column(type="string", length=1, nullable=false)
     */
    public $activo;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=false)
     */
    public $responsable_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('responsable_id', 'Persona', 'persona_id', ['alias' => 'Persona']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'unidad';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Unidad[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Unidad
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
