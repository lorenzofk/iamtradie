import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon, FontAwesomeLayers } from '@fortawesome/vue-fontawesome';

// Solid Icons
import {
  faHouse,
  faCalendarDays,
  faBars,
  faUsers,
  faUserTie,
  faPenToSquare,
  faTrash,
  faRectangleXmark,
} from '@fortawesome/free-solid-svg-icons';

// Regular Icons
//import { } from '@fortawesome/free-regular-svg-icons';

library.add(
  faHouse,
  faCalendarDays,
  faBars,
  faUsers,
  faUserTie,
  faPenToSquare,
  faTrash,
  faRectangleXmark,
);

export default function SetupFontAwesome(app) {
  /**
   * Register our FontAwesome component
   * https://github.com/FortAwesome/vue-fontawesome
   */
  app.component('font-awesome-icon', FontAwesomeIcon);
  app.component('font-awesome-layers', FontAwesomeLayers);
  return app;
}
