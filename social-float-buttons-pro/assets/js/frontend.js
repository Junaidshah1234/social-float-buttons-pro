/* ─────────────────────────────────────
   Social Float Buttons Pro - Frontend Scripts
   ───────────────────────────────────── */

(function() {
  'use strict';
  
  /**
   * DOM Ready
   */
  document.addEventListener('DOMContentLoaded', function() {
    
    const container = document.querySelector('.sfbp-container');
    if (!container) return;
    
    const toggleBtn = container.querySelector('.sfbp-toggle-btn');
    const popup = container.querySelector('.sfbp-popup');
    
    if (!toggleBtn || !popup) return;
    
    /**
     * Toggle Popup
     */
    toggleBtn.addEventListener('click', function(e) {
      e.preventDefault();
      
      const isActive = popup.classList.contains('active');
      
      if (isActive) {
        // Close
        popup.classList.remove('active');
        toggleBtn.classList.remove('active');
        toggleBtn.setAttribute('aria-expanded', 'false');
      } else {
        // Open
        popup.classList.add('active');
        toggleBtn.classList.add('active');
        toggleBtn.setAttribute('aria-expanded', 'true');
      }
    });
    
    /**
     * Close on Outside Click
     */
    document.addEventListener('click', function(e) {
      if (!container.contains(e.target) && popup.classList.contains('active')) {
        popup.classList.remove('active');
        toggleBtn.classList.remove('active');
        toggleBtn.setAttribute('aria-expanded', 'false');
      }
    });
    
    /**
     * Close on Escape Key
     */
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && popup.classList.contains('active')) {
        popup.classList.remove('active');
        toggleBtn.classList.remove('active');
        toggleBtn.setAttribute('aria-expanded', 'false');
        toggleBtn.focus();
      }
    });
    
    /**
     * Add Pulse Animation (Only on first load)
     */
    const hasPulsed = sessionStorage.getItem('sfbp_pulsed');
    if (!hasPulsed) {
      toggleBtn.classList.add('pulse');
      sessionStorage.setItem('sfbp_pulsed', 'true');
      
      // Remove pulse after first interaction
      const removePulse = function() {
        toggleBtn.classList.remove('pulse');
        toggleBtn.removeEventListener('click', removePulse);
      };
      toggleBtn.addEventListener('click', removePulse);
    }
    
    /**
     * Accessibility
     */
    toggleBtn.setAttribute('aria-expanded', 'false');
    toggleBtn.setAttribute('aria-haspopup', 'true');
    toggleBtn.setAttribute('aria-label', 'Toggle social media buttons');
    
  });
  
})();