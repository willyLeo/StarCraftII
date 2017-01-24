<?php

class TipoSocio extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=11, nullable=false)
     */
    public $tipo_socio_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $tipo_socio;

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
        $this->hasMany('tipo_socio_id', 'Socio', 'tipo_socio_id', ['alias' => 'Socio']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tipo_socio';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TipoSocio[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TipoSocio
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
