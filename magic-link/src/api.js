import magicLinkRequest from "./magicLinkRequest";

export const searchMeetingsWithGroups = async (params) => {
    return magicLinkRequest('search_meetings_with_groups', params)
}

export const getMeeting = async (id) => {
    return magicLinkRequest('meeting', {
        'meeting_id': id
    })
}

export const getMeetings = async (params) => {
    return magicLinkRequest('meetings', params)
}

export const login = async (data) => {
    return magicLinkRequest('login', data, 'POST')
}

export const logout = async (data) => {
    return magicLinkRequest('logout', data, 'POST')
}

export const createAccount = async (data) => {
    return magicLinkRequest('register', data, 'POST')
}

export const searchGroups = async (data) => {
  return magicLinkRequest('search_groups', data, 'GET')
}

export const getGroups = async (data) => {
    return magicLinkRequest('groups', data, 'GET')
}

export const saveMeeting = async (data) => {
    return magicLinkRequest('meeting', data, 'PUT')
}

export const searchMeetings = async (data) => {
  return magicLinkRequest('search_meetings', data, 'GET')
}

export const createMeeting = async (data) => {
    return magicLinkRequest('meeting', data, 'POST')
}

