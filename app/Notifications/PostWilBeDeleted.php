<?php


namespace App\Notifications;

use App\Helpers\Date;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Post;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class PostWilBeDeleted extends Notification implements ShouldQueue
{
	use Queueable;
	
	protected $post;
	protected $days;
	
	public function __construct(Post $post, $days)
	{
		$this->post = $post;
		$this->days = $days;
	}
	
	public function via($notifiable)
	{
		if ($this->days <= 0) {
			return false;
		}
		
		if (!empty($this->post->email)) {
			return ['mail'];
		} else {
			if (config('settings.sms.driver') == 'twilio') {
				return [TwilioChannel::class];
			}
			
			return ['nexmo'];
		}
	}
	
	public function toMail($notifiable)
	{
		$repostUrl = url('account/archived/' . $this->post->id . '/repost');
		
		return (new MailMessage)
			->subject(trans('mail.post_will_be_deleted_title', [
				'title' => $this->post->title,
				'days'  => $this->days,
			]))
			->greeting(trans('mail.post_will_be_deleted_content_1'))
			->line(trans('mail.post_will_be_deleted_content_2', [
				'title'   => $this->post->title,
				'days'    => $this->days,
				'appName' => config('app.name'),
			]))
			->line(trans('mail.post_will_be_deleted_content_3', ['repostUrl' => $repostUrl]))
			->line(trans('mail.post_will_be_deleted_content_4', [
				'dateDel' => Date::format($this->post->archived_at->addDays($this->days)),
			]))
			->line(trans('mail.post_will_be_deleted_content_5'))
			->line('<br>')
			->line(trans('mail.post_will_be_deleted_content_6'))
			->salutation(trans('mail.footer_salutation', ['appName' => config('app.name')]));
	}
	
	public function toNexmo($notifiable)
	{
		return (new NexmoMessage())->content($this->smsMessage())->unicode();
	}
	
	public function toTwilio($notifiable)
	{
		return (new TwilioSmsMessage())->content($this->smsMessage());
	}
	
	protected function smsMessage()
	{
		return trans('sms.post_will_be_deleted_content', ['appName' => config('app.name'), 'title' => $this->post->title, 'days' => $this->days]);
	}
}
