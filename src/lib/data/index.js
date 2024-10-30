import { registerStore } from '@wordpress/data';
import { headlineStudioStoreConfig, headlineStudioStoreKey } from '../dataStore';

registerStore(headlineStudioStoreKey, headlineStudioStoreConfig);

// eslint-disable-next-line import/prefer-default-export
export { headlineStudioStoreKey };
