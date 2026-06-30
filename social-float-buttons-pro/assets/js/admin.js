/* ─────────────────────────────────────
   Social Float Buttons Pro - Admin Scripts
   ───────────────────────────────────── */

(function($) {
  'use strict';
  
  /**
   * Color Picker Sync
   */
  const colorPicker = document.getElementById('button_color');
  const colorHex = document.getElementById('button_color_hex');
  
  if (colorPicker && colorHex) {
    colorPicker.addEventListener('input', function() {
      colorHex.value = this.value;
    });
    
    colorHex.addEventListener('input', function() {
      let val = this.value.trim();
      if (val.match(/^#[a-fA-F0-9]{6}$/)) {
        colorPicker.value = val;
      }
    });
  }
  
  /**
   * Save Confirmation
   */
  const form = document.getElementById('sfbp-form');
  const statusEl = document.querySelector('.sfbp-save-status');
  
  if (form && statusEl) {
    form.addEventListener('submit', function() {
      // Show saving indicator
      const submitBtn = form.querySelector('.sfbp-save-btn');
      if (submitBtn) {
        submitBtn.textContent = 'Saving...';
        submitBtn.disabled = true;
      }
      
      // Show success after short delay (WordPress handles actual save)
      setTimeout(function() {
        if (statusEl) {
          statusEl.textContent = '✓ Settings saved!';
          statusEl.classList.add('show');
          
          setTimeout(function() {
            statusEl.classList.remove('show');
          }, 3000);
        }
        
        if (submitBtn) {
          submitBtn.textContent = 'Save Changes';
          submitBtn.disabled = false;
        }
      }, 1000);
    });
  }
  
  /**
   * Toggle Switch Enhancement
   */
  const toggles = document.querySelectorAll('.sfbp-toggle input[type="checkbox"]');
  
  toggles.forEach(function(toggle) {
    toggle.addEventListener('change', function() {
      const wrapper = this.closest('.sfbp-social-field-wrapper');
      const inputs = wrapper ? wrapper.querySelectorAll('input[type="url"], input[type="text"], input[type="email"]') : [];
      
      inputs.forEach(function(input) {
        if (this.checked) {
          input.style.opacity = '1';
          input.style.pointerEvents = 'auto';
        } else {
          input.style.opacity = '0.5';
          input.style.pointerEvents = 'none';
        }
      }.bind(this));
      
      // Trigger initial state
      this.dispatchEvent(new Event('change'));
    });
    
    // Initial state
    toggle.dispatchEvent(new Event('change'));
  });
  
})(jQuery);