<div class="modal" id="loginModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; z-index:99999; background:rgba(0,0,0,0.5); align-items:center; justify-content:center; overflow-y:auto;">
        <div class="modal-content" style="position:relative; max-height:90vh; overflow-y:auto; border-radius:18px;">
        <span class="close" id="closeLogin" style="position:absolute; top:16px; right:20px; font-size:22px; cursor:pointer; z-index:10;">&times;</span>
        @include('auth.login')
    </div>
</div>