<?php
declare(strict_types=1);

namespace MixerApi\Exception;

use Cake\Core\Exception\CakeException;

class InstallException extends CakeException
{
    public const SOURCE_FILE_MISSING = 'Unable to locate %s, your install might fail. Please report a bug.';
    public const DESTINATION_FILE_EXISTS = '%s already exists at %s. Do you want to overwrite it?';
    public const COPY_FAILED = 'Unable to copy %s to destination %s.';
    private bool $canContinue = false;
    private bool $canCopy = false;

    /**
     * @param bool $canContinue Should the CLI prompt the user to continue past this exception?
     * @return $this
     */
    public function setCanContinue(bool $canContinue)
    {
        $this->canContinue = $canContinue;

        return $this;
    }

    /**
     * @return bool
     */
    public function canContinue(): bool
    {
        return $this->canContinue;
    }

    /**
     * @return bool
     */
    public function canCopy(): bool
    {
        return $this->canCopy;
    }

    /**
     * @param bool $canCopy Can the file still be copied after this exception?
     * @return $this
     */
    public function setCanCopy(bool $canCopy)
    {
        $this->canCopy = $canCopy;

        return $this;
    }
}
