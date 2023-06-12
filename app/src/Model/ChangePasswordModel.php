<?php
/**
 * Change Password model.
 */

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ChangePasswordModel.
 */
class ChangePasswordModel
{
    /**
     * OldPassword.
     */
    #[Assert\NotBlank]
    protected string $oldPassword;

    /**
     * NewPassword.
     */
    #[Assert\Length(min: 3, max: 64)]
    #[Assert\NotBlank]
    protected string $newPassword;

    /**
     * Getter for old password.
     *
     * @return string oldPassword
     */
    public function getOldPassword(): string
    {
        return $this->oldPassword;
    }

    /**
     * Setter for old password.
     *
     * @param string $oldPassword Old Password
     *
     * @return ChangePasswordModel Old Password
     */
    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    /**
     * Getter for new password.
     *
     * @return string newPassword
     */
    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    /**
     * Setter for new password.
     *
     * @param string $newPassword New Password
     *
     * @return ChangePasswordModel New Password
     */
    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }
}
