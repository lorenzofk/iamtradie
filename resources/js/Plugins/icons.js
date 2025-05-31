import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon, FontAwesomeLayers } from '@fortawesome/vue-fontawesome';

// Solid Icons
import {
  faChartBar,
  faPlus,
  faHistory,
  faMobileAlt,
  faCode,
  faCog,
  faSignOutAlt,
  faQuoteRight,
} from '@fortawesome/free-solid-svg-icons';

// Regular Icons
//import { } from '@fortawesome/free-regular-svg-icons';

// Svg Icons
// import {} from '@fortawesome/free-brands-svg-icons';

library.add(
  faChartBar,
  faPlus,
  faHistory,
  faMobileAlt,
  faCode,
  faCog,
  faSignOutAlt,
  faQuoteRight,
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
