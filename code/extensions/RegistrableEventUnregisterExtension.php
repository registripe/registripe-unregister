<?php

class RegistrableEventUnregisterExtension extends DataExtension
{

	private static $db = array(
		'AfterUnregTitle' => 'Varchar(255)',
		'AfterUnregContent' => 'HTMLText',
		'AfterConfUnregTitle' => 'Varchar(255)',
		'AfterConfUnregContent' => 'HTMLText'
	);

	private static $defaults = array(
		'AfterUnregTitle' => 'Registration Canceled',
		'AfterUnregContent' => '<p>Your registration has been canceled.</p>',
		'AfterConfUnregTitle' => 'Un-Registration Confirmed',
		'AfterConfUnregContent' => '<p>Your registration has been canceled.</p>'
	);

	public function updateCMSFields(FieldList $fields) {

		$fields->insertAfter(
			new ToggleCompositeField(
				'AfterUnRegistrationContent',
				_t('EventRegistration.AFTER_UNREG_CONTENT', 'After Un-Registration Content'),
				array(
					new TextField('AfterUnregTitle', _t('EventRegistration.TITLE', 'Title')),
					new HtmlEditorField('AfterUnregContent', _t('EventRegistration.CONTENT', 'Content'))
				)
			),
			'AfterRegistrationContent'
		);

		if ($this->owner->UnRegEmailConfirm) {
			$fields->addFieldToTab('Root.Main', new ToggleCompositeField(
				'AfterUnRegistrationConfirmation',
				_t('EventRegistration.AFTER_UNREG_CONFIRM_CONTENT', 'After Un-Registration Confirmation Content'),
				array(
					new TextField('AfterConfUnregTitle', _t('EventRegistration.TITLE', 'Title')),
					new HtmlEditorField('AfterConfUnregContent', _t('EventRegistration.CONTENT', 'Content'))
				)
			));
		}
	}

}


class RegistrableEvent_ControllerUnregisterExtension extends Extension {

	public static $allowed_actions = array(
		'unregister'
	);

	/**
	 * @return EventUnregisterController
	 */
	public function unregister() {
		return new EventUnregisterController($this, $this->owner->dataRecord);
	}

}