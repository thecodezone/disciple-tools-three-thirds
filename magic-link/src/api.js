import magicLinkRequest from "./magicLinkRequest";

/**
 * Request to search meetings
 * @param params
 * @returns {Promise<Promise<unknown> | Promise<unknown>>}
 */
export const searchMeetingsWithGroups = async (params) => {
    return magicLinkRequest('search_meetings_with_groups', params)
}

/**
 * Request to get a meeting by ID
 * @param id
 * @returns {Promise<Promise<unknown> | Promise<unknown>>}
 */
export const getMeeting = async (id) => {
    return magicLinkRequest('meeting', {
        'meeting_id': id
    })
}

/**
 * Request to get a list of meetings
 * @param params
 * @returns {Promise<Promise<unknown> | Promise<unknown>>}
 */
export const getMeetings = async (params) => {
    return magicLinkRequest('meetings', params)
}

/**
 * Request to Login a user
 * @param data
 * @returns {Promise<Promise<unknown> | Promise<unknown>>}
 */
export const login = async (data) => {
    return magicLinkRequest('login', data, 'POST')
}

/**
 * Request to logout a user
 * @param data
 * @returns {Promise<Promise<unknown> | Promise<unknown>>}
 */
export const logout = async (data) => {
    return magicLinkRequest('logout', data, 'POST')
}

/**
 * Request to create a new account
 * @param data
 * @returns {Promise<Promise<unknown> | Promise<unknown>>}
 */
export const createAccount = async (data) => {
    return magicLinkRequest('register', data, 'POST')
}

/**
 * Request to perform a full-text search on a groups
 * @param data
 * @returns {Promise<Promise<unknown> | Promise<unknown>>}
 */
export const searchGroups = async (data) => {
  return magicLinkRequest('search_groups', data, 'GET')
}

/**
 * Request to get all groups
 * @param data
 * @returns {Promise<Promise<unknown> | Promise<unknown>>}
 */
export const getGroups = async (data) => {
    return magicLinkRequest('groups', data, 'GET')
}

/**
 * Request to save a meeting
 * @param data
 * @returns {Promise<Promise<unknown> | Promise<unknown>>}
 */
export const saveMeeting = async (data) => {
    return magicLinkRequest('meeting', data, 'PUT')
}

/**
 * Request to do a full text search n meetings
 * @param data
 * @returns {Promise<Promise<unknown> | Promise<unknown>>}
 */
export const searchMeetings = async (data) => {
  return magicLinkRequest('search_meetings', data, 'GET')
}

/**
 * Request to create a meeting
 * @param data
 * @returns {Promise<Promise<unknown> | Promise<unknown>>}
 */
export const createMeeting = async (data) => {
    return magicLinkRequest('meeting', data, 'POST')
}

