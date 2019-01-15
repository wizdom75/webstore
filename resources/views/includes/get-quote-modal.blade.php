<div class="reveal" id="quote_modal"  data-token="{{ $token }}" data-reveal>
    <div id="contactForm" class="small-8 medium-8 large-8 columns">
        <div class="notification callout primary"></div>
        <form id="getQuoteForm"  action="{{ getenv('APP_URL') }}/message" method="post" data-abide>

            <h5>Send message</h5>
            <label>Name</label>
            <small class="error reveal">Your full name is required.</small>
            <input name="fullname" type="text" placeholder="Full Name" required>
            <input name="id" value=""  type="hidden">
            <input name="return" value="{{ $_SERVER['REQUEST_URI'] }}"  type="hidden">
            <input type="hidden" name="token" value="{{ \App\classes\CSRFToken::_token() }}">


            <label>Email</label>
            <small class="error reveal">An email address is required.</small>

            <input name="email" type="email" placeholder="name@example.com" required>

            <label>Your Message</label>
            <small class="error reveal">Your message is required.</small>
            <textarea name="message" style="height: 6em " placeholder="Enter your message here" required></textarea>

            <button @submit="checkForm" @click.prevent="send()" class="nice blue radius button" >
                Send request
            </button></a>
        </form>
        <button class="close-button" data-close aria-label="Close reveal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>