<?php



namespace JobAd\Domain\Model\Category;

Use JobAd\Domain\ValueObjects\UuidIdentifier;
use Ramsey\Uuid\Uuid;

/**
 * Description of Id
 *
 * @author vedran
 */
class Id extends UuidIdentifier
{
    protected $value;
    
    public function __construct(Uuid $value)
    {
        $this->value = $value;
    }
}
