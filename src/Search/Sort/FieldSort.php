<?php namespace Nord\Lumen\Elasticsearch\Search\Sort;

use Nord\Lumen\Elasticsearch\Search\Traits\HasField;

class FieldSort extends AbstractSort
{
    use HasField;
    
    public const MISSING_FIRST = '_first';
    public const MISSING_LAST  = '_last';

    /**
     * @var ?string The missing parameter specifies how docs which are missing the field should be treated. The missing
     * value can be set to _last, _first, or a custom value (that will be used for missing docs as the sort value).
     */
    private $missing;

    /**
     * @var ?string By default, the search request will fail if there is no mapping associated with a field. The
     * unmapped_type option allows to ignore fields that have no mapping and not sort by them. The value of this
     * parameter is used to determine what sort values to emit.
     */
    private $unmappedType;

    /**
     * FieldSort constructor.
     *
     * @param null|string $field
     * @param null|string $order
     */
    public function __construct(?string $field = null, ?string $order = null)
    {
        if ($field !== null) {
            $this->setField($field);
        }

        if ($order !== null) {
            $this->setOrder($order);
        }
    }

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        $options = $this->applyOptions([]);

        $missing = $this->getMissing();
        if (null !== $missing) {
            $options['missing'] = $missing;
        }

        $unmappedType = $this->getUnmappedType();
        if (null !== $unmappedType) {
            $options['unmapped_type'] = $unmappedType;
        }

        if (empty($options)) {
            return $this->getField();
        } else {
            return [$this->getField() => $options];
        }
    }


    /**
     * @param string $missing
     * @return FieldSort
     */
    public function setMissing($missing)
    {
        $this->missing = $missing;
        return $this;
    }


    /**
     * @return string|null
     */
    public function getMissing(): ?string
    {
        return $this->missing;
    }


    /**
     * @param string $unmappedType
     * @return FieldSort
     */
    public function setUnmappedType($unmappedType)
    {
        $this->unmappedType = $unmappedType;
        return $this;
    }


    /**
     * @return string|null
     */
    public function getUnmappedType(): ?string
    {
        return $this->unmappedType;
    }
}
