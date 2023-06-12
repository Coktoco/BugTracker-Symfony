<?php
/**
 * Change Info model.
 */

namespace App\Model;

/**
 * Class ChangeInfoModel.
 */
class ChangeInfoModel
{
    /**
     * Email.
     */
    private ?string $email = null;

    /**
     * Getter for email.
     *
     * @return string|null email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Setter for email.
     *
     * @param string|null $email Email
     *
     * @return ChangeInfoModel Email
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
