import { registerPlugin } from '@wordpress/plugins';
import HeadlineStudioIcon from './elements/hs-icon';
import CustomSidebar from './CustomSidebar';

registerPlugin('hs-sidebar', {
  icon: <HeadlineStudioIcon />,
  render: CustomSidebar,
});
