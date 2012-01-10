var XMenu = {

   // METHOD :: Sets position of submenus
   init : function() {

      XMenu.menuList = $$('.menu-item');
      Array.each(XMenu.menuList, function(el, i) {

         el.store('menu-id', i);
         el.addEvent('click', XMenu.onClick);
         el.addEvent('mouseover', XMenu.onMouseover);

      });

      XMenu.submenuList = $$('.submenu');
      Array.each(XMenu.submenuList, function(el, i) {

         el.position({
            relativeTo: XMenu.menuList[i],
            position: 'bottomLeft',
            edge: 'upperLeft',
            offset: { x: 0, y: 2 }
         });

      });

      window.addEvent('click', XMenu.onFocusSwitch);

   },

   // METHOD :: Opens the menu
   onClick : function() {

      var id = this.retrieve('menu-id');
      var el = XMenu.submenuList[id];

      if (el && !el.isVisible()) {

         this.addClass('active');
         Xirt.fadeIn(el, 1);

      }

   },

   // METHOD :: Shows new submenu on mouseover (if menu is open)
   onMouseover : function() {

      if (!XMenu.submenuList.every(function(m) { return !m.isVisible(); })) {

         var id = this.retrieve('menu-id');
         var current = XMenu.submenuList[id];
         var submenus = XMenu.submenuList;

         submenus.each(function(submenu, key) {

            if (submenu != current && submenu.isVisible()) {

               XMenu.menuList[key].removeClass('active');
               Xirt.fadeAway(submenu);

            }

         });

         if (!current.isVisible()) {

            this.addClass('active');
            Xirt.fadeIn(current, 1);

         }

      }

   },

   // METHOD :: Handles clicks on document
   onFocusSwitch: function (event) {

      if (!XMenu.menuList.some(function(m) { return (m == event.target); })) {

         XMenu.submenuList.each(function(submenu, key) {

            if (submenu.isVisible()) {

               XMenu.menuList[key].removeClass('active');
               Xirt.fadeAway(submenu);

            }

         });

      }

   }

}
window.addEvent('domready', XMenu.init);