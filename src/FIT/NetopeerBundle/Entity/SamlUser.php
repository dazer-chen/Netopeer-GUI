<?php
/**
 * Custom entity for saml user
 *
 * @file GenerateController.php
 * @author David Alexa <alexa.david@me.com>
 *
 * Copyright (C) 2012-2015 CESNET
 *
 * LICENSE TERMS
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in
 *    the documentation and/or other materials provided with the
 *    distribution.
 * 3. Neither the name of the Company nor the names of its contributors
 *    may be used to endorse or promote products derived from this
 *    software without specific prior written permission.
 *
 * ALTERNATIVELY, provided that this notice is retained in full, this
 * product may be distributed under the terms of the GNU General Public
 * License (GPL) version 2 or later, in which case the provisions
 * of the GPL apply INSTEAD OF those given above.
 *
 * This software is provided ``as is'', and any express or implied
 * warranties, including, but not limited to, the implied warranties of
 * merchantability and fitness for a particular purpose are disclaimed.
 * In no event shall the company or contributors be liable for any
 * direct, indirect, incidental, special, exemplary, or consequential
 * damages (including, but not limited to, procurement of substitute
 * goods or services; loss of use, data, or profits; or business
 * interruption) however caused and on any theory of liability, whether
 * in contract, strict liability, or tort (including negligence or
 * otherwise) arising in any way out of the use of this software, even
 * if advised of the possibility of such damage.
 *
 */
namespace FIT\NetopeerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="samlUser")
 */
class SamlUser extends \AerialShip\SamlSPBundle\Entity\SSOStateEntity implements UserInterface
{

	/**
	 * initialize User object and generates salt for password
	 */
	public function __construct()
	{
		if (!$this->customData instanceof UserCustomData) {
			$this->customData  = new UserCustomData();
		}
		$this->setRoles('ROLE_ADMIN');
	}

	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var string username
	 *
	 * @ORM\Column(type="string", length=64, nullable=true)
	 * @ORM\JoinColumn(onDelete="cascade")
	 */
	protected $username;

	/**
	 * @var string targetedId
	 *
	 * @ORM\Column(type="string", length=64, nullable=true, name="targeted_id")
	 * @ORM\JoinColumn(onDelete="cascade")
	 */
	protected $targetedID;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=32, name="provider_id", nullable=true)
	 */
	protected $providerID;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=32, name="auth_svc_name")
	 */
	protected $authenticationServiceName;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=64, name="session_index", nullable=true)
	 */
	protected $sessionIndex;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=64, name="name_id")
	 */
	protected $nameID;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=64, name="name_id_format")
	 */
	protected $nameIDFormat;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime", name="created_on")
	 */
	protected $createdOn;

	/**
	 * @var UserCustomData
	 * @ORM\OneToOne(targetEntity="UserCustomData", cascade={"all"}, fetch="EAGER")
	 * @ORM\JoinColumn(name="user_data", referencedColumnName="id")
	 */
	protected $customData;

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * Set providerID
	 *
	 * @param string $providerID
	 *
	 * @return SamlUser
	 */
	public function setProviderID($providerID)
	{
		$this->providerID = $providerID;

		return $this;
	}

	/**
	 * Get providerID
	 *
	 * @return string
	 */
	public function getProviderID()
	{
		return $this->providerID;
	}

	/**
	 * Set authenticationServiceName
	 *
	 * @param string $authenticationServiceName
	 *
	 * @return SamlUser
	 */
	public function setAuthenticationServiceName($authenticationServiceName)
	{
		$this->authenticationServiceName = $authenticationServiceName;

		return $this;
	}

	/**
	 * Get authenticationServiceName
	 *
	 * @return string
	 */
	public function getAuthenticationServiceName()
	{
		return $this->authenticationServiceName;
	}

	/**
	 * Set sessionIndex
	 *
	 * @param string $sessionIndex
	 *
	 * @return SamlUser
	 */
	public function setSessionIndex($sessionIndex)
	{
		$this->sessionIndex = $sessionIndex;

		return $this;
	}

	/**
	 * Get sessionIndex
	 *
	 * @return string
	 */
	public function getSessionIndex()
	{
		return $this->sessionIndex;
	}

	/**
	 * Set nameID
	 *
	 * @param string $nameID
	 *
	 * @return SamlUser
	 */
	public function setNameID($nameID)
	{
		$this->nameID = $nameID;

		return $this;
	}

	/**
	 * Get nameID
	 *
	 * @return string
	 */
	public function getNameID()
	{
		return $this->nameID;
	}

	/**
	 * Set nameIDFormat
	 *
	 * @param string $nameIDFormat
	 *
	 * @return SamlUser
	 */
	public function setNameIDFormat($nameIDFormat)
	{
		$this->nameIDFormat = $nameIDFormat;

		return $this;
	}

	/**
	 * Get nameIDFormat
	 *
	 * @return string
	 */
	public function getNameIDFormat()
	{
		return $this->nameIDFormat;
	}

	/**
	 * Set createdOn
	 *
	 * @param \DateTime $createdOn
	 *
	 * @return SamlUser
	 */
	public function setCreatedOn($createdOn)
	{
		$this->createdOn = $createdOn;

		return $this;
	}

	/**
	 * Get createdOn
	 *
	 * @return \DateTime
	 */
	public function getCreatedOn()
	{
		return $this->createdOn;
	}

	/**
	 * don't know, why this method must exist, but some
	 * error occurred without
	 *
	 * @return array
	 */
	public function __sleep()
	{
		return array('id');
	}

	/**
	 * Set user settings
	 *
	 * @param UserSettings $settings
	 */
	public function setSettings(UserSettings $settings)
	{
		$this->customData->setSettings($settings);
	}

	/**
	 * Get user settings
	 *
	 * @return UserSettings
	 */
	public function getSettings()
	{
		return $this->customData->getSettings();
	}

	/**
	 * Add connection either to history or profile
	 *
	 * @param BaseConnection $conn
	 * @param int            $kind kind of connection
	 */
	public function addConnection(BaseConnection $conn, $kind)
	{
		$this->customData->addConnection($conn, $kind);
	}

	/**
	 * Get connectedDevicesInHistory
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getConnectedDevicesInHistory()
	{
		return $this->customData->getConnectedDevicesInHistory();
	}

	/**
	 * Get connectedDevicesInProfiles
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getConnectedDevicesInProfiles()
	{
		return $this->customData->getConnectedDevicesInProfiles();
	}

	/**
	 * Add connectedDevicesInHistory
	 *
	 * @param \FIT\NetopeerBundle\Entity\BaseConnection $connectedDevicesInHistory
	 *
	 * @return User
	 */
	public function addConnectedDevicesInHistory(\FIT\NetopeerBundle\Entity\BaseConnection $connectedDevicesInHistory)
	{
		$this->customData->addConnectedDevicesInHistory($connectedDevicesInHistory);

		return $this;
	}

	/**
	 * Remove connectedDevicesInHistory
	 *
	 * @param \FIT\NetopeerBundle\Entity\BaseConnection $connectedDevicesInHistory
	 */
	public function removeConnectedDevicesInHistory(\FIT\NetopeerBundle\Entity\BaseConnection $connectedDevicesInHistory)
	{
		$this->customData->removeConnectedDevicesInHistory($connectedDevicesInHistory);
	}

	/**
	 * Add connectedDevicesInProfiles
	 *
	 * @param \FIT\NetopeerBundle\Entity\BaseConnection $connectedDevicesInProfiles
	 *
	 * @return User
	 */
	public function addConnectedDevicesInProfile(\FIT\NetopeerBundle\Entity\BaseConnection $connectedDevicesInProfiles)
	{
		$this->addConnectedDevicesInProfile($connectedDevicesInProfiles);

		return $this;
	}

	/**
	 * Remove connectedDevicesInProfiles
	 *
	 * @param \FIT\NetopeerBundle\Entity\BaseConnection $connectedDevicesInProfiles
	 */
	public function removeConnectedDevicesInProfile(\FIT\NetopeerBundle\Entity\BaseConnection $connectedDevicesInProfiles)
	{
		$this->customData->removeConnectedDevicesInProfile($connectedDevicesInProfiles);
	}

	/**
	 * Set roles
	 *
	 * @param string $roles
	 *
	 * @return SamlUser
	 */
	public function setRoles($roles)
	{
		$this->customData->setRoles($roles);

		return $this;
	}

	/**
	 * Get roles
	 *
	 * @return string
	 */
	public function getRoles()
	{
		return $this->customData->getRoles();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPassword() {
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSalt() {
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function eraseCredentials() {
	}

	/**
	 * Set username
	 *
	 * @param string $username
	 *
	 * @return SamlUser
	 */
	public function setUsername($username)
	{
		$this->username = $username;

		return $this;
	}

	/**
	 * Get username
	 *
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}

    /**
     * Set targetedID
     *
     * @param string $targetedID
     * @return SamlUser
     */
    public function setTargetedID($targetedID)
    {
        $this->targetedID = $targetedID;
    
        return $this;
    }

    /**
     * Get targetedID
     *
     * @return string 
     */
    public function getTargetedID()
    {
        return $this->targetedID;
    }

    /**
     * Set customData
     *
     * @param \FIT\NetopeerBundle\Entity\UserCustomData $customData
     * @return SamlUser
     */
    public function setCustomData(\FIT\NetopeerBundle\Entity\UserCustomData $customData = null)
    {
        $this->customData = $customData;
    
        return $this;
    }

    /**
     * Get customData
     *
     * @return \FIT\NetopeerBundle\Entity\UserCustomData 
     */
    public function getCustomData()
    {
        return $this->customData;
    }
}